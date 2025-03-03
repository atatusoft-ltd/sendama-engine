<?php

namespace Sendama\Engine\Events\Traits;

use Assegai\Collections\ItemList;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObservableInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;

/**
 * Trait ObservableTrait. Defines the methods for an observable object.
 *
 * @package Sendama\Engine\Events\Traits
 */
trait ObservableTrait
{
  /**
   * @var ItemList<ObserverInterface>|null $observers The observers to notify for events.
   */
  protected ?ItemList $observers = null;
  /**
   * @var ItemList<StaticObserverInterface>|null $staticObservers The static observers to notify for events.
   */
  protected static ?ItemList $staticObservers = null;

  /**
   * Adds the given observers to the list of observers to notify for events.
   *
   * @param ObserverInterface|StaticObserverInterface|string ...$observers
   * @return void
   */
  public function addObservers(ObserverInterface|StaticObserverInterface|string ...$observers): void
  {
    if (!$this->observers) {
      $this->observers = new ItemList(ObserverInterface::class);
    }

    if (!self::$staticObservers) {
      self::$staticObservers = new ItemList(StaticObserverInterface::class);
    }

    foreach ($observers as $observer) {
      if ($observer instanceof ObserverInterface) {
        $this->observers->add($observer);
      }

      if ($observer instanceof StaticObserverInterface) {
        self::$staticObservers->add($observers);
      }
    }
  }

  /**
   * Removes the given observers from the list of observers to notify for events.
   *
   * @param ObserverInterface|StaticObserverInterface|string|null ...$observers
   * @return void
   */
  public function removeObservers(ObserverInterface|StaticObserverInterface|string|null ...$observers): void
  {
    foreach ($observers as $observer) {
      if ($observer instanceof ObserverInterface && $this->observers) {
        $this->observers->remove($observer);
      }

      if ($observer instanceof StaticObserverInterface && self::$staticObservers) {
        self::$staticObservers->remove($observers);
      }
    }
  }

  /**
   * Notifies an observer that the given event occurred.
   *
   * @param EventInterface $event The event that occurred.
   * @return void
   */
  public function notify(EventInterface $event): void
  {
    if ($this->observers) {
      /** @var ObserverInterface $observer */
      foreach ($this->observers as $observer) {
        assert($this instanceof ObservableInterface);
        $observer->onNotify($this, $event);
      }
    }

    if (self::$staticObservers) {
      /** @var StaticObserverInterface $observer */
      foreach (self::$staticObservers as $observer) {
        $observer::onNotify($this, $event);
      }
    }
  }
}