<?php

namespace Sendama\Engine\UI\Menus\Interfaces;

use Sendama\Engine\Core\Interfaces\ExecutableInterface;
use Stringable;

/**
 * Represents a menu item. A menu item is an element in a menu.
 *
 * @package Sendama\Engine\UI\Menus\Interfaces
 */
interface MenuItemInterface extends Stringable, ExecutableInterface
{
  /**
   * Returns the label of the menu item.
   *
   * @return string The label of the menu item.
   */
  public function getLabel(): string;

  /**
   * Sets the label of the menu item.
   *
   * @param string $label The label of the menu item.
   * @return void
   */
  public function setLabel(string $label): void;

  /**
   * Returns the icon of the menu item.
   *
   * @return string The icon of the menu item.
   */
  public function getIcon(): string;

  /**
   * Sets the icon of the menu item.
   *
   * @param string $icon The icon of the menu item.
   * @return void
   */
  public function setIcon(string $icon);

  /**
   * Returns the description of the menu item.
   *
   * @return string The description of the menu item.
   */
  public function getDescription(): string;

  /**
   * Sets the description of the menu item.
   *
   * @param string $description The description of the menu item.
   * @return void
   */
  public function setDescription(string $description): void;
}