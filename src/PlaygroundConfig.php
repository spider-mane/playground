<?php

namespace WebTheory\Playground;

use Composer\InstalledVersions;

class PlaygroundConfig
{
    protected string $root;

    protected array $config;

    protected string $defaultDirname = '@playground';

    protected string $defaultWebRoot = 'public';

    protected string $defaultWebLink = '@playground';

    protected string $defaultInclude = 'vendor/autoload.php';

    public function __construct()
    {
        $package = InstalledVersions::getRootPackage();
        $path = realpath($package['install_path']);
        $composer = file_get_contents($path . '/composer.json');
        $config = json_decode($composer)->extra->playground;

        $this->root = realpath($path);
        $this->config = (array) $config;
    }

    public function path(): string
    {
        return $this->getPathTo(
            $this->config['directory'] ?? $this->defaultDirname
        );
    }

    public function contexts(): array
    {
        return $this->config['contexts'] ?? [];
    }

    public function webRoot(): string
    {
        return $this->getPathTo(
            $this->config['web-root'] ?? $this->defaultWebRoot
        );
    }

    public function webLink(): string
    {
        return $this->config['web-link'] ?? $this->defaultWebLink;
    }

    public function include(): string
    {
        return $this->config['bootstrap'] ?? $this->defaultInclude;
    }

    public function levels(): int
    {
        $ds = DIRECTORY_SEPARATOR;
        $slashes = ['/', '\\'];

        $path = explode($ds, str_replace($slashes, $ds, $this->path()));
        $root = explode($ds, str_replace($slashes, $ds, $this->root));

        return count($path) - count($root);
    }

    protected function getPathTo(string $file): string
    {
        return $this->root . DIRECTORY_SEPARATOR . $file;
    }
}
