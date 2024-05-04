<?php

namespace Sendama\Engine\Events\Interfaces;

/**
 * Interface SubjectInterface. This interface is implemented by classes that want to be observed.
 *
 * @package Sendama\Engine\Events\Interfaces
 */
interface SubjectInterface
{
  /**
   * This method is called when an observer is added.
   *
   * @param ObserverInterface|string $observer The observer that is being added. If a string is passed, it is assumed
   * to be the name of a class that implements the StaticObserverInterface.
   */
  public function addObserver(ObserverInterface|string $observer): void;

  /**
   * This method is called when an observer is removed.
   *
   * @param ObserverInterface|string $observer The observer that is being removed. If a string is passed, it is assumed
   * to be the name of a class that implements the StaticObserverInterface.
   */
  public function removeObserver(ObserverInterface|string $observer): void;

  /**
   * This method is called when an event is fired.
   *
   * @param EventInterface $event The event that is being observed.
   */
  public function notify(EventInterface $event): void;
}