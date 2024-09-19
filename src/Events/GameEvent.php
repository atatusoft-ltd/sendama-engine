<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Enumerations\GameEventType;
use Sendama\Engine\Events\Event;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

/**
 * GameEvent is the base class for all game events.
 */
readonly class GameEvent extends Event
{
  /**
   * Constructs a new instance of the GameEvent class.
   *
   * @param GameEventType $gameEventType The type of GameEvent.
   * @param EventTargetInterface|null $target The event target. Defaults to null.
   * @param DateTimeInterface $timestamp The timestamp. Defaults to now.
   * @param mixed|null $data The data associated with the event. Defaults to null.
   */
  public function __construct(
    public GameEventType $gameEventType,
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable(),
    protected mixed $data = null,
  )
  {
    parent::__construct(EventType::GAME, $target, $timestamp);
  }

  /**
   * Gets the data associated with the event.
   *
   * @return mixed The data associated with the event.
   */
  public function getData(): mixed
  {
    return $this->data;
  }
}