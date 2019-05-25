<?php

/**
 * This file is part of prooph/pdo-event-store.
 * (c) 2016-2019 prooph software GmbH <contact@prooph.de>
 * (c) 2016-2019 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\EventStore\Pdo\WriteLockStrategy;

use Prooph\EventStore\Pdo\WriteLockStrategy;

final class PostgresAdvisoryLockStrategy implements WriteLockStrategy
{
    /**
     * @var \PDO
     */
    private $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getLock(string $name): bool
    {
        $this->connection->exec('select pg_advisory_lock( hashtext(\'' . $name . '\') );');

        return true;
    }

    public function releaseLock(string $name): bool
    {
        $this->connection->exec('select pg_advisory_unlock( hashtext(\'' . $name . '\') );');

        return true;
    }
}
