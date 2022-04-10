<?php

declare(strict_types=1);

namespace App\Shared\Snapshot;

use App\Money\Domain\Account;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Snapshotting\AggregateRootRepositoryWithSnapshotting;
use EventSauce\EventSourcing\Snapshotting\AggregateRootWithSnapshotting;
use EventSauce\EventSourcing\Snapshotting\Snapshot;
use EventSauce\EventSourcing\Snapshotting\SnapshotRepository;
use EventSauce\MessageRepository\DoctrineMessageRepository\DoctrineUuidV4MessageRepository;
use Generator;

class DoctrineAggregateRootRepositoryWithSnapshotting implements AggregateRootRepositoryWithSnapshotting
{
    public function __construct(
        private string                  $aggregateRootClassName,
        private MessageRepository       $messageRepository,
        private SnapshotRepository      $snapshotRepository,
        private AggregateRootRepository $aggregateRootRepository
    ) {
        EventSourcedAggregateRootRepository::class;
//        $this->aggregateRootRepository = new EventSourcedAggregateRootRepository(
//            Account::class,
//            $messageRepository,
//            $messageDispatcher
//        );

//        $messageRepository = new DoctrineUuidV4MessageRepository(
//            connection: $connection,
//            tableName: 'account_events',
//            serializer: new ConstructingMessageSerializer(),
//            tableSchema: new DefaultTableSchema(),
//            uuidEncoder: new StringUuidEncoder(),
//        );

//            $this->repo = new ConstructingAggregateRootRepositoryWithSnapshotting (
//            Account::class,
//            $messageRepository,
//            new DoctrineSnapshotRepository(AccountId::class, 'account_snapshots', $connection, new StringUuidEncoder()),
//            new EventSourcedAggregateRootRepository(
//                Account::class,
//                $messageRepository,
//                $dispatcher
//            )
//        );
    }

    public function retrieve(AggregateRootId $aggregateRootId): Account
    {
        return $this->aggregateRootRepository->retrieve($aggregateRootId);
    }

    public function persist(object $aggregateRoot): void
    {
        $this->aggregateRootRepository->persist($aggregateRoot);
        if ($aggregateRoot->aggregateRootVersion() % 10 === 0) {
            dump('doing snapshot');
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
        $className = $this->aggregateRootClassName;
        $events = $this->retrieveAllEventsAfterVersion($aggregateRootId, $snapshot->aggregateRootVersion());

        return $className::reconstituteFromSnapshotAndEvents($snapshot, $events);
    }

    public function storeSnapshot(AggregateRootWithSnapshotting $aggregateRoot): void
    {
        $snapshot = $aggregateRoot->createSnapshot();
        $this->snapshotRepository->persist($snapshot);
    }

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