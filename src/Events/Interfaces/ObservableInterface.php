<?php

namespace Sendama\Engine\Events\Interfaces;

/**
 * Defines an object that can be observed for events.
 */
interface ObservableInterface
{
  /**
   * Adds the given observers to the list of observers to notify for events.
   *
   * @param ObserverInterface ...$observers The list of observers.
   * @return void
   */
  public function addObservers(ObserverInterface ...$observers): void;

  /**
   * Removes the given observers from the list of observers to notify for events.
   *
   * @param ObserverInterface ...$observers The list of observers to de-register.
   * @return void
   */
  public function removeObservers(ObserverInterface ...$observers): void;

  /**
   * Notifies an observer that the given event occurred.
   *
   * @param ObserverInterface $observer The observer to be notified of the event.
   * @param EventInterface $event The event that occurred.
   * @return void
   */
  public function notify(ObserverInterface $observer, EventInterface $event): void;
}