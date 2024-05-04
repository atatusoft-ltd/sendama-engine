<?php

namespace Sendama\Engine\Events\Interfaces;

use Sendama\Engine\Core\Interfaces\CanEquate;

/**
 * Interface EventListenerInterface
 *
 * @package Sendama\Engine\Events\Interfaces
 */
interface EventListenerInterface extends CanEquate
{
  /**
   * Handles the given event.
   *
   * @param EventInterface $event The event to handle.
   * @return void
   */
  public function handle(EventInterface $event): void;

  /**
   * Gets the unique id of the event listener.
   *
   * @return string The unique id of the event listener.
   */
  public function getUniqueId(): string;
}