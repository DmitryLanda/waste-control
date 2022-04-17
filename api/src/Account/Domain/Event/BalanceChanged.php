<?php

declare(strict_types=1);

namespace App\Account\Domain\Event;

use DateTimeImmutable;
use DateTimeInterface;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

abstract class BalanceChanged implements SerializablePayload
{
    private const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';
    public const SOURCE_HTTP = 'http';

    public function __construct(
        private string $userId,
        private string $accountId,
        private float             $amount,
        private DateTimeInterface $timestamp,
        private string            $comment,
        private array             $tags = [],
        private string            $source = self::SOURCE_HTTP,
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function toPayload(): array
    {
        return [
            'user_id' => $this->userId,
            'account_id' => $this->accountId,
            'amount'    => $this->amount,
            'comment'   => $this->comment,
            'tags'      => $this->tags,
            'source'    => $this->source,
            'timestamp' => $this->timestamp->format(self::TIMESTAMP_FORMAT),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            (string)$payload['user_id'],
            (string)$payload['account_id'],
            (float)$payload['amount'],
            DateTimeImmutable::createFromFormat(self::TIMESTAMP_FORMAT, $payload['timestamp']),
            (string)$payload['comment'],
            (array)$payload['tags'],
            (string)$payload['source']
        );
    }
}