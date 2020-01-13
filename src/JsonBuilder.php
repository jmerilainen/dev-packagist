<?php

namespace Frc\Satis;

use Symfony\Component\Finder\Finder;

class JsonBuilder
{
    protected $name;

    protected $homepage;

    protected $root;

    protected $input;

    protected $folder;

    protected $satis = [];

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function from($folder)
    {
        $this->folder = $folder;
        $this->generate("{$this->root}/{$this->folder}");
        return $this;
    }

    protected function generate($input)
    {
        $files = (new Finder)->files()->in($input)->name('*.zip');
        $files = array_keys(iterator_to_array($files));

        $files = array_map(function($path) {
            $basename = basename($path);
            return [
                'url' => str_replace($this->root, '', $path),
                'version' => $this->parseVersionFromFile($basename),
                'name' => $this->parsePackageNameFromFile($basename),
                'vendor' => basename(dirname($path)),
            ];
        }, $files);

        $files = array_map(function($args) {
            return $this->generatePackageJson($args);
        }, $files);

        $external = file_get_contents("{$input}/external.json");
        $json = json_decode($external, true)['repositories'];

        $satis = array_merge($json, $files);

        $this->satis = $this->generateSatisJson($files);
    }

    public function name($input)
    {
        $this->satis['name'] = $input;
        return $this;
    }

    public function homepage($input)
    {
        $this->satis['homepage'] = $input;
        return $this;
    }

    public function save($name)
    {
        $path = "{$this->root}/{$name}";
        $file = fopen($path, 'w');
        fwrite(
            $file,
            json_encode($this->satis, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
        fclose($file);
    }

    protected function parseVersionFromFile($file)
    {
        preg_match('/\d+(\.\d+)+/', $file, $matches);
        return $matches[0];
    }

    protected function parsePackageNameFromFile($file)
    {
        return preg_replace('/[\.\-_][\dv]+(\.\d+)+.[^\.]+$/', '', $file);
    }

    protected function generatePackageJson($args)
    {
        return [
            "type" => "package",
            "package" => [
                "name" => $args['vendor'] . '/' . $args['name'],
                "version" => $args['version'],
                "type" => "wordpress-plugin",
                "dist" => [
                    "url" => $args['url'],
                    "type" => "zip"
                ],
            ],
        ];
    }

    protected function generateSatisJson($pacakges)
    {
        return [
            "name" => $this->name,
            "homepage" => ltrim($this->homepage, '/'),
            "repositories" => $pacakges,
            "archive" => [
                "directory" => $this->folder,
                "format" => "tar",
                "skip-dev" => true
            ],
            "require-all" => true,
        ];
    }
}
