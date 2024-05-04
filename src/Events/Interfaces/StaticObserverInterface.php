<?php

namespace Sendama\Engine\Events\Interfaces;

interface StaticObserverInterface
{
  /**
   * Handles an occurring event from a given observable.
   *
   * @param ObservableInterface $observable The object for which the event was observed.
   * @param EventInterface $event The occurring event.
   * @return void
   */
  public static function onNotify(ObservableInterface $observable, EventInterface $event): void;
}