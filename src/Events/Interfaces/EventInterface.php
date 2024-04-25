<?php

namespace Sendama\Engine\Events\Interfaces;

use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;

/**
 * Interface for events.
 */
interface EventInterface
{
  /**
   * Gets the type of the event.
   *
   * @return EventType The type of the event.
   */
  public function getType(): EventType;

  /**
   * Returns the type of the event as a string.
   *
   * @return string The type of the event as a string.
   */
  public function getTypeAsString(): string;

  /**
   * Gets the target of the event.
   *
   * @return EventTargetInterface|null The target of the event.
   */
  public function getTarget(): ?EventTargetInterface;

  /**
   * Gets the timestamp of the event.
   *
   * @return DateTimeInterface The timestamp of the event.
   */
  public function getTimestamp(): DateTimeInterface;
}