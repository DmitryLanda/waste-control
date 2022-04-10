<?php

namespace App\Money\Domain\Repository;

use EventSauce\EventSourcing\Snapshotting\AggregateRootRepositoryWithSnapshotting;

interface AccountRepositoryInterface extends AggregateRootRepositoryWithSnapshotting
{

}