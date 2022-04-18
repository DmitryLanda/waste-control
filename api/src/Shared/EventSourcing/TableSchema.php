<?php

declare(strict_types=1);

namespace App\Shared\EventSourcing;

class TableSchema
{
    public function __construct(
        private string $snapshotIdColumn = 'snapshot_id',
        private string $aggregateRootIdColumn = 'aggregate_root_id',
        private string $versionColumn = 'version',
        private string $stateColumn = 'state',
        private string $createdAtColumn = 'created_at',
    ) {}

    public function getSnapshotIdColumn(): string
    {
        return $this->snapshotIdColumn;
    }

    public function getAggregateRootIdColumn(): string
    {
        return $this->aggregateRootIdColumn;
    }

    public function getVersionColumn(): string
    {
        return $this->versionColumn;
    }

    public function getStateColumn(): string
    {
        return $this->stateColumn;
    }

    public function getCreatedAtColumn(): string
    {
        return $this->createdAtColumn;
    }
}