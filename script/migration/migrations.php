<?php
/**
 * Migrations CLI Application:
 *
 * Usage:
 * $ php migrations.php migrations:status
 * $ php migrations.php migrations:migrate
 */

require_once __DIR__ . '/../../vendor/autoload.php';
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

$dbConfig = require_once __DIR__ . '/../../application/config/database_config.php';

$db = DriverManager::getConnection(array(
    'dbname' => $dbConfig['database'],
    'user' => $dbConfig['username'],
    'password' => $dbConfig['password'],
    'host' => $dbConfig['hostname'],
    'driver' => 'pdo_mysql',
    'charset' => 'utf8',
    'driverOptions' => array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    )
));
$helperSet = new HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($db),
    'dialog' => new \Symfony\Component\Console\Helper\DialogHelper,
));
$console = new Application;
$console->setHelperSet($helperSet);
$console->addCommands(array(
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand,
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand,
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand,
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand,
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand,
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand,
));

$input = file_exists(__DIR__ . '/migrations-input.php')
       ? include(__DIR__ . '/migrations-input.php')
       : null;

$output = file_exists(__DIR__ . '/migrations-output.php')
        ? include(__DIR__ . '/migrations-output.php')
        : null;

$console->run($input, $output);
