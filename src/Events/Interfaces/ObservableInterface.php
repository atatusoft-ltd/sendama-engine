<?php

namespace Sendama\Engine\Events\Interfaces;

/**
 * Defines an object that can be observed for events.
 *
 * @package Sendama\Engine\Events\Interfaces
 */
interface ObservableInterface
{
  /**
   * Adds the given observers to the list of observers to notify for events.
   *
   * @param ObserverInterface|StaticObserverInterface|string ...$observers
   * @return void
   */
  public function addObservers(ObserverInterface|StaticObserverInterface|string ...$observers): void;

  /**
   * Removes the given observers from the list of observers to notify for events.
   *
   * @param ObserverInterface|StaticObserverInterface|string|null ...$observers
   * @return void
   */
  public function removeObservers(ObserverInterface|StaticObserverInterface|string|null ...$observers): void;

  /**
   * Notifies an observer that the given event occurred.
   *
   * @param EventInterface $event The event that occurred.
   * @return void
   */
  public function notify(EventInterface $event): void;
}