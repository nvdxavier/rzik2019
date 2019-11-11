<?php

namespace App\DataFixtures\ORM;


class PicturesFixtures extends AbstractAliceFixture
{
    protected function getFixturesFiles(): array
    {
        return [
            __DIR__ . '/picturefixtures.yaml',
        ];
    }

}
