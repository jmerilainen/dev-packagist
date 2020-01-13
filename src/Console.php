<?php

namespace Frc\Satis;

class Console
{
    public function execute()
    {
        (new JsonBuilder(realpath(__DIR__ . '/..')))
            ->from('packages')
            ->name('jmerilainen/packagist')
            ->homepage('https://jmerilainen-packagist-storage.s3.eu-north-1.amazonaws.com')
            ->save('.satis.json');
    }
}
