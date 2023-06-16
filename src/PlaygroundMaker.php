<?php

namespace WebTheory\Playground;

class PlaygroundMaker
{
    protected string $root;

    protected array $contexts;

    protected string $webRoot;

    protected string $directory = "@playground";

    protected string $defaultContext = "console";

    protected string $webContext = "browser";

    protected string $webLink = "@playground";

    protected string $bootstrapFile;

    /**
     * Create a new BeginnerClass.
     */
    public function __construct(
        string $root,
        array $contexts = [],
        string $bootstrapFile = 'vendor/autoload.php',
        string $webRoot = 'public'
    ) {
        $this->root = $root;
        $this->contexts = $contexts;
        $this->bootstrapFile = $bootstrapFile;
        $this->webRoot = $webRoot;
    }

    public function erect(): void
    {
        $root = $this->root;
        $path = "{$root}/{$this->directory}";
        $content = $this->getFileContent();
        $webRoot = "{$root}/{$this->webRoot}";
        $contexts = [$this->defaultContext, ...$this->contexts];

        if (!file_exists($path)) {
            mkdir($path);
        }

        foreach ($contexts as $context) {
            $file = "{$path}/{$context}.php";

            if (!file_exists($file)) {
                file_put_contents($file, $content);
            }

            if ($this->webContext === $context && file_exists($webRoot)) {
                $uri = $uri ?? "@playground";
                $link = "{$webRoot}/{$this->webLink}.php";

                if (file_exists($link)) {
                    unlink($link);
                }

                symlink($file, $link);
            }
        }
    }

    protected function getFileContent(): string
    {
        return <<<PHP
        <?php

        declare(strict_types=1);

        require_once dirname(__DIR__) . '/{$this->bootstrapFile}';

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
