<?php

namespace Sendama\Engine\UI\Menus\Interfaces;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\ExecutionContextInterface;
use Sendama\Engine\Events\Interfaces\SubjectInterface;
use Sendama\Engine\IO\Enumerations\Color;
use Sendama\Engine\UI\Interfaces\UIElementInterface;

/**
 * Interface MenuInterface. Represents a menu.
 *
 * @package Sendama\Engine\UI\Menus\Interfaces
 */
interface MenuInterface extends
  UIElementInterface,
  SubjectInterface,
  MenuGraphNodeInterface,
  ExecutionContextInterface
{
  /**
   * Returns the title of the menu.
   *
   * @return string The title of the menu.
   */
  public function getTitle(): string;

  /**
   * Sets the title of the menu.
   *
   * @param string $title The title of the menu.
   * @return void
   */
  public function setTitle(string $title): void;

  /**
   * Returns the description of the menu.
   *
   * @return string The description of the menu.
   */
  public function getDescription(): string;

  /**
   * Sets the description of the menu.
   *
   * @param string $description The description of the menu.
   * @return void
   */
  public function setDescription(string $description): void;

  /**
   * Returns a list of items in the menu.
   *
   * @return ItemList The list of items in the menu.
   */
  public function getItems(): ItemList;

  /**
   * Sets the list of items in the menu.
   *
   * @param ItemList $items The list of items in the menu.
   * @return void
   */
  public function setItems(ItemList $items): void;

  /**
   * Adds an item to the menu.
   *
   * @param MenuItemInterface $item The item to add to the menu.
   * @return void
   */
  public function addItem(MenuItemInterface $item): void;

  /**
   * Removes an item from the menu.
   *
   * @param MenuItemInterface $item The item to remove from the menu.
   * @return void
   */
  public function removeItem(MenuItemInterface $item): void;

  /**
   * Removes an item from the menu by index.
   *
   * @param int $index The index of the item to remove.
   * @return void
   */
  public function removeItemByIndex(int $index): void;

  /**
   * Returns an item by index.
   *
   * @param int $index The index of the item to return.
   * @return MenuItemInterface|null The item at the index or null if not found.
   */
  public function getItemByIndex(int $index): ?MenuItemInterface;

  /**
   * Returns an item by label.
   *
   * @param string $label The label of the item to return.
   * @return MenuItemInterface|null The item with the specified label or null if not found.
   */
  public function getItemByLabel(string $label): ?MenuItemInterface;

  /**
   * Returns the active item.
   *
   * @return MenuItemInterface|null The active item or null if not set.
   */
  public function getActiveItem(): ?MenuItemInterface;

  /**
   * Sets the active item.
   *
   * @param MenuItemInterface $item The item to set as active.
   * @return void
   */
  public function setActiveItem(MenuItemInterface $item): void;

  /**
   * Returns the index of the active item.
   *
   * @return int The index of the active item.
   */
  public function getActiveItemIndex(): int;

  /**
   * Sets the active item by index.
   *
   * @param int $index The index of the item to set as active.
   * @return void
   */
  public function setActiveItemByIndex(int $index): void;

  /**
   * Sets the active item by label.
   *
   * @param string $label The label of the item to set as active.
   * @return void
   */
  public function setActiveItemByLabel(string $label): void;

  /**
   * Sets the cursor of the menu.
   *
   * @param string $cursor The cursor of the menu.
   * @return void
   */
  public function setCursor(string $cursor): void;

  /**
   * Sets the color of the active item.
   *
   * @param Color $color The color of the active item.
   * @return void
   */
  public function setActiveColor(Color $color): void;

  /**
   * Updates the content of the window.
   *
   * @return void
   */
  public function updateWindowContent(): void;
}