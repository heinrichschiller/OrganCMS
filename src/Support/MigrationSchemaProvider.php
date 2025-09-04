<?php

declare(strict_types=1);

namespace App\Support;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\Provider\SchemaProvider;

final class MigrationSchemaProvider implements SchemaProvider
{
	public function createSchema(): Schema
	{
		return require __DIR__ . '/../../config/schema.php';
	}
}
