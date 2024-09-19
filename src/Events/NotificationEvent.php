<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Enumerations\NotificationEventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

/**
 * Class NotificationEvent. Represents a notification event.
 *
 * @package Sendama\Engine\Events
 */
readonly class NotificationEvent extends Event
{
  /**
   * NotificationEvent constructor.
   *
   * @param NotificationEventType $notificationEventType The notification event type.
   * @param EventTargetInterface|null $target The event target.
   * @param DateTimeInterface $timestamp The event timestamp.
   */
  public function __construct(
    public NotificationEventType $notificationEventType,
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable(),
  )
  {
    parent::__construct(
      EventType::NOTIFICATION,
      $target,
      $timestamp,
    );
  }
}