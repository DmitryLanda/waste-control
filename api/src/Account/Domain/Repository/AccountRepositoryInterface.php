<?php

namespace App\Account\Domain\Repository;

use EventSauce\EventSourcing\Snapshotting\AggregateRootRepositoryWithSnapshotting;

interface AccountRepositoryInterface extends AggregateRootRepositoryWithSnapshotting
{

}