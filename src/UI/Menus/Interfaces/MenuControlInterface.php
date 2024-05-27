<?php

namespace Sendama\Engine\UI\Menus\Interfaces;

use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Events\Interfaces\ObservableInterface;

interface MenuControlInterface extends MenuItemInterface, CanUpdate, ObservableInterface
{
  /**
   * Gets the value of the menu control.
   *
   * @return mixed The value of the menu control.
   */
  public function getValue(): mixed;

  /**
   * Sets the value of the menu control.
   *
   * @param mixed $value The value of the menu control.
   */
  public function setValue(mixed $value): void;

  /**
   * Called when the vertical input is received.
   *
   * @param int $direction The direction of the input.
   * @return void
   */
  public function onVerticalInput(int $direction): void;

  /**
   * Called when the horizontal input is received.
   *
   * @param int $direction The direction of the input.
   * @return void
   */
  public function onHorizontalInput(int $direction): void;
}