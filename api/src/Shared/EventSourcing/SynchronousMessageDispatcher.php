<?php

declare(strict_types=1);

namespace App\Shared\EventSourcing;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use EventSauce\EventSourcing\MessageDispatcher;

class SynchronousMessageDispatcher implements MessageDispatcher
{
    /**
     * @var iterable<MessageConsumer>
     */
    private iterable $consumers;

    public function __construct(iterable $consumers)
    {
        $this->consumers = $consumers;
    }

    public function dispatch(Message ...$messages): void
    {
        foreach ($messages as $message) {
            foreach ($this->consumers as $consumer) {
                $consumer->handle($message);
            }
        }
    }
}