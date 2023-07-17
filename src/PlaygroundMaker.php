<?php

namespace WebTheory\Playground;

class PlaygroundMaker
{
    protected array $defaultContexts = ['console'];

    protected string $webContext = 'browser';

    public function __construct(protected PlaygroundConfig $config)
    {
        //
    }

    public function make(): void
    {
        $path = $this->config->path();
        $content = $this->getFileContent();
        $webRoot = $this->config->webRoot();
        $webLink = $this->config->webLink();
        $contexts = [
            ...$this->getDefaultContexts(),
            ...$this->config->contexts(),
        ];

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        foreach ($contexts as $context) {
            $file = "{$path}/{$context}.php";

            if (!file_exists($file)) {
                file_put_contents($file, $content);
            }

            if ($this->getWebContext() === $context && file_exists($webRoot)) {
                $uri = $uri ?? "@playground";
                $link = "{$webRoot}/{$webLink}.php";

                if (file_exists($link)) {
                    unlink($link);
                }

                symlink($file, $link);
            }
        }
    }

    protected function getDefaultContexts(): array
    {
        return $this->defaultContexts;
    }

    protected function getWebContext(): string
    {
        return $this->webContext;
    }

    protected function getFileContent(): string
    {
        $levels = $this->config->levels();
        $script = $this->config->include();

        return <<<PHP
        <?php

        declare(strict_types=1);

        require_once dirname(__DIR__, {$levels}) . '/{$script}';

        /**
         *==============================================================================
         * PHP Playground
         *==============================================================================
         *
         * This is a burner file for when you just need to mess around and find out.
         *
         * Hint: To avoid having to comment out large sections of code, wrap each sample
         * in a simple if statement. Set the condition to false to disable and delete
         * when no longer needed.
         *
         */

        if (true) {
            // code here
        }

        PHP;
    }
}
