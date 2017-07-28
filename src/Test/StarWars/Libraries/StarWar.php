<?php

namespace Test\StarWars\Libraries;

class StarWar
{
    /** @var array */
    private $starWarsDetails = array(
        'darkVador' => array(
            'count' => 1,
            'lifeSpan' => 100,
            'hitpoint' => 9
        ),
        'stormTrooper' => array(
            'count' => 5,
            'lifeSpan' => 85,
            'hitpoint' => 10
        ),
        'droneTrooper' => array(
            'count' => 8,
            'lifeSpan' => 45,
            'hitpoint' => 14
        )
    );

    /**
     * Construct
     *
     * @param Array|null $starWarsDetails starwar details
     *
     */
    public function __construct($starWarsDetails = null)
    {
        if (!empty($starWarsDetails) && is_array($starWarsDetails)) {
            $this->buildDetails($starWarsDetails);
        } else {
            $this->buildDetails($this->starWarsDetails);
        }
    }

    /**
     * Get star war details
     *
     * @return array
     */
    public function getStarWarsDetails()
    {
        return $this->starWarsDetails;
    }

    /**
     * Set star war details
     *
     * @param Array $starWarsDetails
     */
    public function setStarWarDetails(array $starWarsDetails)
    {
        $this->starWarsDetails = $starWarsDetails;
    }

    /**
     * Build star war details array
     *
     * @param array $starWarsDetails
     *
     * @return array
     */
    public function buildDetails(array $starWarsDetails)
    {
        foreach($starWarsDetails as &$starWarDetails) {
            if (isset($starWarDetails['row'])) {
                break;
            }

            unset($starWarDetails['row']);

            for($i=1; $i <= $starWarDetails['count']; $i++) {
                $starWarDetails['row'][$i] = $starWarDetails['lifeSpan'];
            }
        }

        $this->starWarsDetails = $starWarsDetails;

        return $this->starWarsDetails;
    }

    /**
     * Get random star war
     *
     * @return mixed
     */
    public function getStarWarTypeToHit()
    {
        return array_rand($this->starWarsDetails);
    }

    /**
     * Get star war number
     *
     * @param int $type
     *
     * @return int|null
     */
    public function getStarWarNumber($type)
    {
        if (isset($this->starWarsDetails[$type])) {
            return rand(1, $this->starWarsDetails[$type]['count']);
        }

        return null;
    }

    /**
     * Is star war have life span
     *
     * @param string $type  Type
     * @param int $number number
     *
     * @return bool
     */
    public function isStarWarHaveLifeSpan($type, $number)
    {
        $starWarLifeSpan = $this->starWarsDetails[$type]['row'][$number];
        if (ctype_digit(strval($starWarLifeSpan)) && ($starWarLifeSpan > 5)) {
            return true;
        }

        return false;
    }

    /**
     * Reduce hit point
     *
     * @param String $type
     * @param int $number
     *
     * @return mixed
     */
    public function reduceHitPoint($type, $number)
    {
        if ($this->isStarWarHaveLifeSpan($type, $number)) {
            $this->starWarsDetails[$type]['row'][$number] -= $this->starWarsDetails[$type]['hitpoint'];
        }

        return $this->starWarsDetails[$type]['row'][$number];
    }

    /**
     * Check the start var status
     *
     * @return bool
     */
    public function isDarkVadorDead()
    {
        foreach($this->starWarsDetails['darkVador']['row'] as $key => $value) {
            if ($value > $this->starWarsDetails['darkVador']['hitpoint']) {
                return false;
            }
        }

        return true;
    }
}
