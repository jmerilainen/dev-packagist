<?php

namespace Frc\Satis;

class Console
{
    public function execute()
    {
        (new JsonBuilder(realpath(__DIR__ . '/..')))
            ->from('packages')
            ->name('jmerilainen/packagist')
            ->homepage('https://packagist.jmerilainen.fi/')
            ->save('.satis.json');
    }
}
