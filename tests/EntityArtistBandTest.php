<?php


namespace App\Tests;


use App\Entity\ArtistBand;
use PHPUnit\Framework\TestCase;

class EntityArtistBandTest extends TestCase
{
    public function testPlaylistProjectDate()
    {
        $artistBand = new ArtistBand();

        $this->assertObjectHasAttribute('id', $artistBand);
        $this->assertObjectHasAttribute('artistbandname', $artistBand);
        $this->assertObjectHasAttribute('artistbanddescription', $artistBand);
        $this->assertObjectHasAttribute('artistbanddateceation', $artistBand);
        $this->assertObjectHasAttribute('artistbandfacebook', $artistBand);
        $this->assertObjectHasAttribute('artistbandtwitter', $artistBand);
        $this->assertObjectHasAttribute('artistbandinstagram', $artistBand);
        $this->assertObjectHasAttribute('artistbandlogo', $artistBand);
        $this->assertObjectHasAttribute('artistbandcountry', $artistBand);
        $this->assertObjectHasAttribute('artistbandcity', $artistBand);
        $this->assertObjectHasAttribute('artistbandcategory', $artistBand);
        $this->assertObjectHasAttribute('artistbandmember', $artistBand);
        $this->assertObjectHasAttribute('artistbandpicture', $artistBand);
        $this->assertObjectHasAttribute('artistbandproject', $artistBand);

    }
}