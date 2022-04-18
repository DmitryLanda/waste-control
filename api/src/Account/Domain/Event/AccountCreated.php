<?php

declare(strict_types=1);

namespace App\Account\Domain\Event;

use DateTime;
use DateTimeInterface;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class AccountCreated implements SerializablePayload
{
    private const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private string $accountId,
        private string $userId,
        private string $name,
        private DateTimeInterface $timestamp,
    ) {}

    public function toPayload(): array
    {
        return [
            'timestamp' => $this->timestamp->format(self::TIMESTAMP_FORMAT),
            'user_id' => $this->getUserId(),
            'account_id' => $this->getAccountId(),
            'account_name' => $this->getAccountName(),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            (string) $payload['account_id'],
            (string) $payload['user_id'],
            (string) $payload['account_name'],
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

    public function getAccountName(): string
    {
        return $this->name;
    }
}