<?php

namespace Test\Test\Libraries;

use Test\StarWars\Libraries;

class StarWars extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotGetEmptyStarWarWhileInstantiation()
    {
        $starWar = new Libraries\StarWar();
        $this->assertNotEmpty($starWar->getStarWarsDetails());
    }

    /**
     * @test
     */
    public function shouldTestStarWarBuildDetails()
    {
        $starWarsDetails = array(
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

        $expected = array(
            'stormTrooper' => array(
                'count' => '3',
                'lifeSpan' => '85',
                'hitpoint' => '10',
                'row' => array(1 => '85',2 => '85', 3 => '85')),
            'droneTrooper' => array(
                'count' => '3',
                'lifeSpan' => '45',
                'hitpoint' => '14',
                'row' => array(1 => '45', 2 => '45', 3 => '45')));

        $starWar = new Libraries\StarWar();
        $this->assertEquals($expected, $starWar->buildDetails($starWarsDetails));
    }

    /**
     * @test
     */
    public function shouldTestStarWarRandomHitNotempty()
    {
        $starWar = new Libraries\StarWar();
        $this->assertNotEmpty($starWar->getStarWarTypeToHit());
    }

    /**
     * @test
     */
    public function shouldReturnNumberIfTypeIsValid()
    {
        $starWar = new Libraries\StarWar();
        $this->assertNotEmpty($starWar->getStarWarNumber('stormTrooper'));
    }

    /**
     * @test
     */
    public function shouldReturnNullIfTypeIsNoTValid()
    {
        $starWar = new Libraries\StarWar();
        $this->assertNull($starWar->getStarWarNumber('test'));
    }

    /**
     * @test
     */
    public function shouldStarWarHaveLifeSpan()
    {
        $starWar = new Libraries\StarWar();
        $this->assertTrue($starWar->isStarWarHaveLifeSpan('droneTrooper', 3));
    }

    /**
     * @test
     */
    public function shouldReduceLifeSpanWhileHit()
    {
        $starWar = new Libraries\StarWar();
        $this->assertEquals(31, $starWar->reduceHitPoint('droneTrooper', 4));
    }

    /**
     * @test
     */
    public function shouldGameFinshDarkVadorIsDead()
    {
        $starWarsDetails = array(
            'darkVador' => array(
                'count' => 1,
                'lifeSpan' => 2,
                'hitpoint' => 9
            ),
            'droneTrooper' => array(
                'count' => 3,
                'lifeSpan' => 45,
                'hitpoint' => 14
            )
        );
        $starWar = new Libraries\StarWar();
        $starWar->buildDetails($starWarsDetails);
        $this->assertEquals(true, $starWar->isDarkVadorDead());

    }
}