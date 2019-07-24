<?php
namespace App\Tests;

use App\Entity\ArtistBand;
use App\Entity\PlaylistProject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit;
use Symfony\Component\HttpFoundation\Request;

class EntityPlaylistProjectTest extends TestCase
{
    public function testArtistNewPlaylistProject()
    {
        $artistNewProject = new PlaylistProject();
        $this->assertObjectHasAttribute('id', $artistNewProject);
        $this->assertObjectHasAttribute('plprojectname', $artistNewProject);
        $this->assertObjectHasAttribute('datecreate_plproject', $artistNewProject);
        $this->assertObjectHasAttribute('plproject_position', $artistNewProject);
        $this->assertObjectHasAttribute('description_plproject', $artistNewProject);
        $this->assertObjectHasAttribute('mainpicture_plproject', $artistNewProject);
        $this->assertObjectHasAttribute('pictures_plproject', $artistNewProject);
        $this->assertObjectHasAttribute('musicfile_plproject', $artistNewProject);
        $this->assertObjectHasAttribute('artistband_plproject', $artistNewProject);
    }

    public function testPlaylistProjectDate()
    {
        $artistBand = new ArtistBand();

        $this->assertObjectHasAttribute('id', $artistBand);
        $this->assertObjectHasAttribute('artistband_name', $artistBand);
        $this->assertObjectHasAttribute('artistband_description', $artistBand);
        $this->assertObjectHasAttribute('artistband_dateceation', $artistBand);
        $this->assertObjectHasAttribute('artistband_facebook', $artistBand);
        $this->assertObjectHasAttribute('artistband_twitter', $artistBand);
        $this->assertObjectHasAttribute('artistband_instagram', $artistBand);
        $this->assertObjectHasAttribute('artistband_logo', $artistBand);
        $this->assertObjectHasAttribute('artistband_country', $artistBand);
        $this->assertObjectHasAttribute('artistband_city', $artistBand);
        $this->assertObjectHasAttribute('artistband_category', $artistBand);
        $this->assertObjectHasAttribute('artistband_member', $artistBand);
        $this->assertObjectHasAttribute('artistband_picture', $artistBand);
        $this->assertObjectHasAttribute('artistband_project', $artistBand);

    }

}