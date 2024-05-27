<?php

namespace Sendama\Engine\UI\Menus\MenuItems;

use Assegai\Collections\ItemList;
use Closure;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;
use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Input;
use Sendama\Engine\UI\Menus\Interfaces\MenuControlInterface;

/**
 * The class AbstractMenuControl.
 *
 * @package Sendama\Engine\UI\Menus
 */
abstract class AbstractMenuControl extends MenuItem implements MenuControlInterface
{
  /**
   * @var ItemList<ObserverInterface> The list of observers.
   */
  protected ItemList $observers;

  /**
   * Constructs a menu control.
   *
   * @param string $label The label of the menu control.
   * @param mixed $value The value of the menu control.
   * @param string $description The description of the menu control.
   * @param string $icon The icon of the menu control.
   * @param Closure|null $callback The callback to execute when the menu control is selected.
   */
  public function __construct(
    string              $label,
    string              $description = '',
    string              $icon = '',
    ?Closure            $callback = null,
    protected mixed     $value = null,
  )
  {
    parent::__construct($label, $description, $icon, $callback);
    $this->observers = new ItemList(ObserverInterface::class);
  }


  /**
   * @inheritDoc
   */
  public function getValue(): mixed
  {
    return $this->value;
  }

  /**
   * @inheritDoc
   */
  public function setValue(mixed $value): void
  {
    $this->value = $value;
  }

  /**
   * @inheritDoc
   */
  public final function update(): void
  {
    $v = Input::getAxis(AxisName::VERTICAL);
    $h = Input::getAxis(AxisName::HORIZONTAL);

    if (abs($v) > 0)
    {
      $this->onVerticalInput($v);
    }

    if (abs($h) > 0)
    {
      $this->onHorizontalInput($h);
    }
  }

  /**
   * @inheritDoc
   */
  public function addObservers(ObserverInterface|StaticObserverInterface|string ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers->add($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(ObserverInterface|StaticObserverInterface|string|null ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers->remove($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    foreach ($this->observers as $observer)
    {
      if ($observer instanceof StaticObserverInterface)
      {
        $observer::onNotify($this, $event);
        continue;
      }

      $observer->onNotify($event);
    }
  }
}