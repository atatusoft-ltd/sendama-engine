<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Enumerations\MapEventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

readonly class MapEvent extends Event
{
  /**
   * MapEvent constructor.
   *
   * @param MapEventType $mapEventType The type of map event.
   * @param array $map The map.
   * @param EventTargetInterface|null $target The event target.
   * @param DateTimeInterface $timestamp The timestamp of the event.
   */
  public function __construct(
    public MapEventType   $mapEventType,
    public array          $map = [],
    ?EventTargetInterface $target = null,
    DateTimeInterface     $timestamp = new DateTimeImmutable()
  )
  {
    parent::__construct(EventType::MAP, $target, $timestamp);
  }
}