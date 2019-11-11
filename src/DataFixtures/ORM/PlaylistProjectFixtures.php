<?php
namespace App\DataFixtures\ORM;


class PlaylistProjectFixtures extends AbstractAliceFixture
{
    protected function getFixturesFiles(): array
    {
        return [
            __DIR__ . '/playlistprojectfixtures.yaml',
            __DIR__ . '/artistbandfixtures.yaml',

        ];
    }

}
