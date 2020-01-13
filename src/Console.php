<?php

namespace Frc\Satis;

class Console
{
    public function execute()
    {
        (new JsonBuilder(realpath(__DIR__ . '/..')))
            ->from('packages')
            ->name('frc/packagist')
            ->homepage('http://packagist.frc.io/')
            ->save('.satis.json');
    }
}
