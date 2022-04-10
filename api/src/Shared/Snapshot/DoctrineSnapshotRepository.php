<?php

namespace App\Shared\Snapshot;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Snapshotting\Snapshot;
use EventSauce\EventSourcing\Snapshotting\SnapshotRepository;
use EventSauce\UuidEncoding\UuidEncoder;
use Ramsey\Uuid\Uuid;
use Throwable;
use Symfony\Component\Serializer\SerializerInterface;

class DoctrineSnapshotRepository implements SnapshotRepository
{
    public function __construct(
        private string $aggregateIdClass,
        private string $tableName,
        private TableSchema $tableSchema,
        private Connection $connection,
        private UuidEncoder $uuidEncoder,
        private SerializerInterface $serializer
    ) {}

    public function persist(Snapshot $snapshot): void
    {
        $columns = [
            $this->tableSchema->getSnapshotIdColumn(),
            $this->tableSchema->getAggregateRootIdColumn(),
            $this->tableSchema->getVersionColumn(),
            $this->tableSchema->getStateColumn(),
            $this->tableSchema->getCreatedAtColumn(),
        ];
        $insertValues = [
            $this->uuidEncoder->encodeUuid(Uuid::uuid4()),
            $this->uuidEncoder->encodeString($snapshot->aggregateRootId()->toString()),
            $snapshot->aggregateRootVersion(),
            json_encode($snapshot->state())
        ];

        $insertQuery = sprintf(
            "INSERT INTO %s (%s) VALUES (?, ?, ?, ?, now())",
            $this->tableName,
            implode(', ', $columns)
        );

        try {
            $this->connection->executeStatement(
                $insertQuery,
                $insertValues
            );
        } catch (Throwable $exception) {
            throw $exception;
        }
    }

    public function retrieve(AggregateRootId $id): ?Snapshot
    {
        $builder = $this->createQueryBuilder();
        $builder->where("{$this->tableSchema->getAggregateRootIdColumn()} = :aggregate_root_id");
        $builder->setParameter('aggregate_root_id', $this->uuidEncoder->encodeString($id->toString()));

        try {
            $result = $builder->executeQuery()->fetchAssociative();
            if (!$result) {
                return null;
            }

            return new Snapshot(
                $this->aggregateIdClass::fromString($result[$this->tableSchema->getAggregateRootIdColumn()]),
                $result[$this->tableSchema->getVersionColumn()],
                json_decode($result[$this->tableSchema->getStateColumn()])
            );
        } catch (Throwable $exception) {
            throw $exception;
        }
    }

    private function createQueryBuilder(): QueryBuilder
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('*');
        $builder->from($this->tableName);
        $builder->orderBy($this->tableSchema->getVersionColumn(), 'DESC');
        $builder->setMaxResults(1);

        return $builder;
    }
}