<?php

$argv = $_SERVER['argv'];
$configArg = 'migrations.yml';
$argv[] = "--configuration=config/{$configArg}";

$input = new \Symfony\Component\Console\Input\ArgvInput($argv);

return $input;
