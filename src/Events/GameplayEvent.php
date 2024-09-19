<?php

namespace Sendama\Engine\Events;

use DateTimeImmutable;
use DateTimeInterface;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Interfaces\EventTargetInterface;

/**
 * The GameplayEvent class represents a game play event.
 *
 * @package Sendama\Engine\Events
 */
readonly class GameplayEvent extends Event
{
  /**
   * Constructs a new instance of the GameplayEvent class.
   *
   * @param EventTargetInterface|null $target The target of the event.
   * @param DateTimeInterface $timestamp The timestamp of the event.
   * @param string $message The message to display.
   * @param mixed|null $data The data to send.
   */
  public function __construct(
    ?EventTargetInterface $target = null,
    DateTimeInterface $timestamp = new DateTimeImmutable(),
    protected string $message = '',
    protected mixed $data = null,
  )
  {
    parent::__construct(EventType::GAME_PLAY, $target, $timestamp);
  }

  /**
   * Gets the message of the event.
   *
   * @return string The message of the event.
   */
  public function getMessage(): string
  {
    return $this->message;
  }

  /**
   * Gets the data of the event.
   *
   * @return mixed The data of the event.
   */
  public function getData(): mixed
  {
    return $this->data;
  }
}