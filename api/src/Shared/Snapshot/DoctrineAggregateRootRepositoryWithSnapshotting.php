<?php

declare(strict_types=1);

namespace App\Shared\Snapshot;

use App\Money\Domain\Account;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Snapshotting\AggregateRootRepositoryWithSnapshotting;
use EventSauce\EventSourcing\Snapshotting\AggregateRootWithSnapshotting;
use EventSauce\EventSourcing\Snapshotting\Snapshot;
use EventSauce\EventSourcing\Snapshotting\SnapshotRepository;
use Generator;

abstract class DoctrineAggregateRootRepositoryWithSnapshotting implements AggregateRootRepositoryWithSnapshotting
{
    public function __construct(
        protected MessageRepository       $messageRepository,
        protected SnapshotRepository      $snapshotRepository,
        protected AggregateRootRepository $aggregateRootRepository
    ) {
    }

    public function retrieve(AggregateRootId $aggregateRootId): Account
    {
        return $this->aggregateRootRepository->retrieve($aggregateRootId);
    }

    public function persist(object $aggregateRoot): void
    {
        $this->aggregateRootRepository->persist($aggregateRoot);
        if ($aggregateRoot->aggregateRootVersion() % 10 === 0) {
            $this->storeSnapshot($aggregateRoot);
        }
    }

    public function persistEvents(AggregateRootId $aggregateRootId, int $aggregateRootVersion, object ...$events): void
    {
        $this->aggregateRootRepository->persistEvents($aggregateRootId, $aggregateRootVersion, ...$events);
    }

    public function retrieveFromSnapshot(AggregateRootId $aggregateRootId): Account
    {
        $snapshot = $this->snapshotRepository->retrieve($aggregateRootId);

        if (!$snapshot instanceof Snapshot) {
            return $this->retrieve($aggregateRootId);
        }

        /** @var AggregateRootWithSnapshotting $className */
        $className = $this->getAggregateRootClassName();
        $events = $this->retrieveAllEventsAfterVersion($aggregateRootId, $snapshot->aggregateRootVersion());

        return $className::reconstituteFromSnapshotAndEvents($snapshot, $events);
    }

    public function storeSnapshot(AggregateRootWithSnapshotting $aggregateRoot): void
    {
        $snapshot = $aggregateRoot->createSnapshot();
        $this->snapshotRepository->persist($snapshot);
    }

    abstract protected function getAggregateRootClassName(): string;

    private function retrieveAllEventsAfterVersion(AggregateRootId $aggregateRootId, int $version): Generator
    {
        /** @var Message[]|Generator $messages */
        $messages = $this->messageRepository->retrieveAllAfterVersion($aggregateRootId, $version);

        foreach ($messages as $message) {
            yield $message->payload();
        }

        return $messages->getReturn();
    }
}