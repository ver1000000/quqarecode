<?php

declare(strict_types=1);

namespace App\Migrations\Clickhouse;

use ClickHouseDB\Client;
use ClickhouseMigrations\AbstractClickhouseMigration;

final class Version20250116112421 extends AbstractClickhouseMigration
{
    public function up(Client $client): void
    {
        $client->write(
            <<<CLICKHOUSE
            CREATE TABLE events (
                id UInt64,
                name String,
                props String
            ) ENGINE = MergeTree()
            ORDER BY id; 
            CLICKHOUSE,
        );
    }
}
