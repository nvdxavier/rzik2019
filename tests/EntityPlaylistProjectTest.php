<?php
namespace App\Tests;

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
        $this->assertObjectHasAttribute('datecreateplproject', $artistNewProject);
        $this->assertObjectHasAttribute('plprojectposition', $artistNewProject);
        $this->assertObjectHasAttribute('descriptionplproject', $artistNewProject);
        $this->assertObjectHasAttribute('mainpictureplproject', $artistNewProject);
        $this->assertObjectHasAttribute('picturesplproject', $artistNewProject);
        $this->assertObjectHasAttribute('musicfileplproject', $artistNewProject);
        $this->assertObjectHasAttribute('artistbandplproject', $artistNewProject);
    }

}
