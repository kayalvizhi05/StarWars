<?php

namespace Test\Test\Controller;

use Symfony\Component\HttpFoundation\Request;
use Test\StarWars\Controller;
use Test\StarWars\Libraries\StarWar;

if(!isset($_SESSION)) $_SESSION = array();
class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $starWarsSession = array('_SESSION');

    public function setUp()
    {
        $_SESSION['starWars'] = array(
            'stormTrooper' => array(
                'count' => 3,
                'lifeSpan' => 85,
                'hitpoint' => 10
            ),
            'droneTrooper' => array(
                'count' => 3,
                'lifeSpan' => 45,
                'hitpoint' => 14
            )
        );
    }

    public function testIndexAction()
    {
        $twig = $this->twigMock();
        $controller = $this->getMockBuilder('Test\StarWars\Controller\DefaultController')
            ->setMethods(array('getTwig'))
            ->getMock();

        $controller
            ->expects($this->once())
            ->method('getTwig')
            ->will($this->returnValue($twig));

        $response = $controller->indexAction(new Request());

        $this->assertNotEmpty($response);
        $this->assertStringStartsWith("<html>", $response);
    }

    /**
     * Get Twig mock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function twigMock()
    {
        $params = array(
            'cache' => false,
            'auto_reload' => true,
            'autoescape' => true
        );

        $twigLoaderFilesystem = $this->getMockBuilder('\Twig_Loader_Filesystem')
            ->setConstructorArgs(array(
                    'src/Test/StarWars/Views')
            )
            ->setMethods(array())
            ->getMock();

        $twig = $this->getMockBuilder('\Twig_Environment')
            ->setConstructorArgs(array($twigLoaderFilesystem, $params))
            ->setMethods(array('display','addExtension'))
            ->getMock();

        $twig
            ->expects($this->once())
            ->method('display')
            ->will($this->returnValue('<html><body>Welcome!</body></html>'));

        return $twig;
    }

    public function testGetStarWarNumber()
    {
        $starWar = new \Test\StarWars\Libraries\StarWar;
        $type = 'darkVador';
        $controller = new \Test\StarWars\Controller\DefaultController;
        $actual = $controller->getStarWarNumber($starWar,$type);

        $this->assertEquals(1, $actual);
    }

    public function testGetStarWarType()
    {
        $starWar = new \Test\StarWars\Libraries\StarWar;

        $controller = new \Test\StarWars\Controller\DefaultController;

        $this->assertNotEmpty($controller->GetStarWarType($starWar));
    }

    public function testGetStarWarsFromSession()
    {
        $controller = new \Test\StarWars\Controller\DefaultController;
        $this->assertNotEmpty($controller->getStarWarsFromSession());
    }

    public function testGetStarWarDetails()
    {
        $controller = new \Test\StarWars\Controller\DefaultController;

        $this->assertNotEmpty($controller->getStarWarDetails());
        $this->assertArrayHasKey('stormTrooper', $controller->getStarWarDetails());
    }
}