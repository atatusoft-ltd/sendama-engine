<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Enumerations\MenuEventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

/**
 * Represents a menu event.
 *
 * @package Sendama\Engine\Events
 */
readonly class MenuEvent extends Event
{
  /**
   * MenuEvent constructor.
   *
   * @param MenuEventType $menuEventType The type of menu event.
   * @param EventTargetInterface|null $target The target of the event.
   * @param DateTimeInterface $timestamp The timestamp of the event.
   */
  public function __construct(
    protected MenuEventType $menuEventType,
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable()
  )
  {
    parent::__construct(EventType::MENU, $target, $timestamp);
  }

  /**
   * The type of menu event.
   *
   * @return MenuEventType The type of menu event.
   */
  public function getMenuEventType(): MenuEventType
  {
    return $this->menuEventType;
  }
}