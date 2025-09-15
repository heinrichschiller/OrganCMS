<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Support\MigrationSchemaProvider;
use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Provider\SchemaProvider;

$settings = require __DIR__ . '/settings.php';
$config = new ConfigurationArray($settings['migrations']);

$connection = DriverManager::getConnection($settings['db']);
$factory = DependencyFactory::fromConnection($config, new ExistingConnection($connection));

$factory->setDefinition(SchemaProvider::class, function () use ($connection) {
	return new MigrationSchemaProvider($connection);
});

return $factory;
