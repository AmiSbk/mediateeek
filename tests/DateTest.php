<?php

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires sur la date de parution au format string
 *
 */
class DateTest extends TestCase {

    /**
     * Test sur la méthode GetPublishedAtString
     */
    public function testGetPublishedAtString(){
       $formation = new Formation();
       $formation->setPublishedAt(new DateTime("2021-01-04"));
       $this->assertEquals("04/01/2021", $formation->getPublishedAtString());
    }
}