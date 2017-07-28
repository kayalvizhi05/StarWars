<?php

namespace Test\StarWars\Controller;

use Test\StarWars\Libraries\StarWar;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
{
    /** @var twig */
    private $twig;

    /**
     * Index and list action
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        unset($_SESSION['starWars']);

        $this->twig = $this->getTwig();

        $starWarDetails = $this->getStarWarDetails();

        $response = $this->twig->display('index.html.twig', array('starWarDetails' => $starWarDetails,
                'href' => $request->server->get('PHP_SELF'))
        );

        return $response;
    }

    /**
     * Hit Action
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function hitAction(Request $request)
    {
        $this->twig = $this->getTwig();

        $starWarInstance = new StarWar($this->getStarWarsFromSession());

        $type = $this->getStarWarType($starWarInstance);

        $number = $this->getStarWarNumber($starWarInstance, $type);

        $lifeSpan = $starWarInstance->reduceHitPoint($type, $number);

        $darkVadorDead = $starWarInstance->isDarkVadorDead($type, $number);

        $starWarDetails = $starWarInstance->getStarWarsDetails();

        $_SESSION['starWars'] = $starWarDetails;

        if ($darkVadorDead) {
            $response = $this->twig->display('gameover.html.twig', array('starWarDetails' => $starWarDetails,
                    'href' => $request->getBaseUrl())
            );

        } else {
            $response = $this->twig->display('index.html.twig', array('starWarDetails' => $starWarDetails,
                    'href' => $request->getBaseUrl())
            );
        }

        return $response;
    }

    /**
     * Get star war number
     *
     * @param Object $starWarInstance
     * @param String $type
     *
     * @return null
     */
    public function getStarWarNumber($starWarInstance, $type)
    {
        $number = null;

        if (isset($_POST['number']) && !empty($_POST['number'])) {
            $number = $_POST['number'];
        } else {
            $number = $starWarInstance->getStarWarNumber($type);
        }

        return $number;
    }

    /**
     * Get star war Type
     *
     * @param Object $starWarInstance
     *
     * @return String
     */
    public function getStarWarType($starWarInstance)
    {
        $type = null;

        if (isset($_POST['type']) && !empty($_POST['type'])) {
            $type = $_POST['type'];
        } else {
            $type = $starWarInstance->getStarWarTypeToHit();
        }

        return $type;
    }

    /**
     * Get Star Wars details from session
     *
     * @return array|null
     */
    public function getStarWarsFromSession()
    {
        $starWars = null;

        if(!empty($_SESSION['starWars']) && isset($_SESSION['starWars']))
        {
            $starWars = $_SESSION['starWars'];
        }

        return $starWars;
    }

    /**
     * Get Star War Details
     *
     * @return array
     */
    public function getStarWarDetails()
    {
        $starWarInstance = new StarWar();

        $starWars = $starWarInstance->getStarWarsDetails();

        return $starWars;
    }

    /**
     * Load Twig
     *
     * @return Twig Object
     */
    public function getTwig()
    {
        // set up environment
        $params = array(
            'cache' => false,
            'auto_reload' => true,
            'autoescape' => true
        );

        $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem(array(
            SITE_PATH. 'src/Test/StarWars/Views'
        )), $params);

        return $this->twig;
    }
}