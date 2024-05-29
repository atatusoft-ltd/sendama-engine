<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

readonly class GameplayEvent extends Event
{
  /**
   * Constructs a new instance of the GameplayEvent class.
   *
   * @param EventTargetInterface|null $target
   * @param DateTimeInterface $timestamp
   */
  public function __construct(
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable()
  )
  {
    parent::__construct(EventType::GAME_PLAY, $target, $timestamp);
  }
}