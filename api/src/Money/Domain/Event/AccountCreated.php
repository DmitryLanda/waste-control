<?php

declare(strict_types=1);

namespace App\Money\Domain\Event;

use DateTime;
use DateTimeInterface;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class AccountCreated implements SerializablePayload
{
    private const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private string $accountId,
        private string $userId,
        private DateTimeInterface $timestamp,
    ) {}

    public function toPayload(): array
    {
        return [
            'timestamp' => $this->timestamp->format(self::TIMESTAMP_FORMAT),
            'user_id' => $this->getUserId(),
            'account_id' => $this->getAccountId(),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            (string) $payload['account_id'],
            (string) $payload['user_id'],
            DateTime::createFromFormat(self::TIMESTAMP_FORMAT, $payload['timestamp']),
        );
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }
}