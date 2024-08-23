<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;
use Sendama\Engine\UI\Modals\Enumerations\ModalEventType;

readonly class ModalEvent extends Event
{
  /**
   * ModalEvent constructor.
   *
   * @param ModalEventType $modalEventType The type of modal event.
   * @param mixed $value The value of the event.
   * @param EventTargetInterface|null $target The target of the event.
   * @param DateTimeInterface $timestamp The timestamp of the event.
   */
  public function __construct(
    public ModalEventType $modalEventType,
    public mixed $value,
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable()
  )
  {
    parent::__construct(EventType::MODAL, $target, $timestamp);
  }
}