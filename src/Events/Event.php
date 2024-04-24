<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

/**
 * Event is the base class for all event classes.
 */
abstract readonly class Event implements EventInterface
{
  /**
   * Constructs a new instance of the Event class.
   *
   * @param EventType $type
   * @param EventTargetInterface|null $target
   * @param DateTimeInterface $timestamp
   */
  public function __construct(
    protected EventType $type,
    protected ?EventTargetInterface $target = null,
    protected DateTimeInterface $timestamp = new DateTimeImmutable()
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function getType(): EventType
  {
    return $this->type;
  }

  /**
   * @inheritDoc
   */
  public function getTypeAsString(): string
  {
    return $this->type->value;
  }

  /**
   * @inheritDoc
   */
  public function getTarget(): ?EventTargetInterface
  {
    return $this->target;
  }

  /**
   * @inheritDoc
   */
  public function getTimestamp(): DateTimeInterface
  {
    return $this->timestamp;
  }
}