<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Enumerations\SceneEventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

readonly class SceneEvent extends Event
{
  public function __construct(
    public SceneEventType $sceneEventType,
    public ?SceneInterface $scene = null,
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable()
  )
  {
    parent::__construct(EventType::SCENE, $target, $timestamp);
  }
}