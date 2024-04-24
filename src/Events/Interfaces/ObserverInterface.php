<?php

namespace Sendama\Engine\Events\Interfaces;

interface ObserverInterface
{
  /**
   * Handles the triggered event.
   *
   * @param ObservableInterface $observable The object for which the event was observed.
   * @param EventInterface $event The occurring event.
   * @return void
   */
  public function onNotify(ObservableInterface $observable, EventInterface $event): void;
}