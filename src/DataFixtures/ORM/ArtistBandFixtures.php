<?php

namespace App\DataFixtures\ORM;

class ArtistBandFixtures extends AbstractAliceFixture
{

    protected function getFixturesFiles(): array
    {
        return [
            __DIR__ . '/artistbandfixtures.yaml',
        ];
    }
}
