<?php

use WebTheory\Playground\PlaygroundConfig;

function play(string $file): void
{
    $config = new PlaygroundConfig();
    $playground = $config->path() . "/{$file}.php";

    if (file_exists($playground)) {
        require_once $playground;
    }
}
