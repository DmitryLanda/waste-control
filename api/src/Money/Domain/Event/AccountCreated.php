<?php

declare(strict_types=1);

namespace App\Money\Domain\Event;

use DateTime;
use DateTimeInterface;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class AccountCreated implements SerializablePayload
{
    private const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private DateTimeInterface $timestamp, private UuidInterface $userId)
    {
    }

    public function toPayload(): array
    {
        return [
            'timestamp' => $this->timestamp->format(self::TIMESTAMP_FORMAT),
            'user_id' => $this->getUserId(),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            DateTime::createFromFormat(self::TIMESTAMP_FORMAT, $payload['timestamp']),
            Uuid::fromString($payload['user_id'])
        );
    }

    public function getUserId(): string
    {
        return $this->userId->toString();
    }
}