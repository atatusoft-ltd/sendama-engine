<?php

namespace Sendama\Engine\UI\Menus;

use Assegai\Collections\ItemList;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuGraphNodeInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuItemInterface;

/**
 * Class Menu. Represents a menu.
 *
 * @package Sendama\Engine\UI\Menus
 */
class Menu implements MenuInterface
{
  /**
   * @var MenuItemInterface|null $activeItem
   */
  protected ?MenuItemInterface $activeItem = null;
  /**
   * @var ItemList<ObserverInterface> $observers
   */
  protected ItemList $observers;
  /**
   * @var MenuGraphNodeInterface|null $topSibling
   */
  protected ?MenuGraphNodeInterface $topSibling = null;
  /**
   * @var MenuGraphNodeInterface|null $rightSibling
   */
  protected ?MenuGraphNodeInterface $rightSibling = null;
  /**
   * @var MenuGraphNodeInterface|null $bottomSibling
   */
  protected ?MenuGraphNodeInterface $bottomSibling = null;
  /**
   * @var MenuGraphNodeInterface|null $leftSibling
   */
  protected ?MenuGraphNodeInterface $leftSibling = null;

  /**
   * Menu constructor.
   *
   * @param string $title The title of the menu.
   * @param string $description The description of the menu.
   * @param ItemList $items The items of the menu.
   */
  public function __construct(
    protected string $title,
    protected string $description = '',
    protected ItemList $items = new ItemList(MenuItemInterface::class)
  )
  {
    $this->observers = new ItemList(ObserverInterface::class);
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    // TODO: Implement render() method.
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement renderAt() method.
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    // TODO: Implement update() method.
  }

  /**
   * @inheritDoc
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @inheritDoc
   */
  public function setTitle(string $title): void
  {
    $this->title = $title;
  }

  /**
   * @inheritDoc
   */
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @inheritDoc
   */
  public function setDescription(string $description): void
  {
    $this->description = $description;
  }

  /**
   * @inheritDoc
   */
  public function getItems(): ItemList
  {
    return $this->items;
  }

  /**
   * @inheritDoc
   */
  public function setItems(ItemList $items): void
  {
    $this->items = $items;
  }

  /**
   * @inheritDoc
   */
  public function addItem(MenuItemInterface $item): void
  {
    $this->items->add($item);
  }

  /**
   * @inheritDoc
   */
  public function removeItem(MenuItemInterface $item): void
  {
    $this->items->remove($item);
  }

  /**
   * @inheritDoc
   */
  public function removeItemByIndex(int $index): void
  {
    $this->items->removeAt($index);
  }

  /**
   * @inheritDoc
   */
  public function getItemByIndex(int $index): ?MenuItemInterface
  {
    return $this->items->toArray()[$index] ?? null;
  }

  /**
   * @inheritDoc
   */
  public function getItemByLabel(string $label): ?MenuItemInterface
  {
    return $this->items->find(fn(MenuItemInterface $item) => $item->getLabel() === $label);
  }

  /**
   * @inheritDoc
   */
  public function getActiveItem(): ?MenuItemInterface
  {
    return $this->activeItem;
  }

  /**
   * @inheritDoc
   */
  public function setActiveItem(MenuItemInterface $item): void
  {
    $this->activeItem = $item;
  }

  /**
   * @inheritDoc
   */
  public function getActiveItemIndex(): int
  {
    $index = -1;

    foreach ($this->items as $i => $item)
    {
      if ($item === $this->activeItem)
      {
        $index = $i;
        break;
      }
    }

    return $index;
  }

  /**
   * @inheritDoc
   */
  public function setActiveItemByIndex(int $index): void
  {
    $this->activeItem = $this->getItemByIndex($index);
  }

  /**
   * @inheritDoc
   */
  public function setActiveItemByLabel(string $label): void
  {
    if ($item = $this->getItemByLabel($label))
    {
      $this->activeItem = $item;
    }
  }

  /**
   * @inheritDoc
   */
  public function addObserver(string|ObserverInterface $observer): void
  {
    $this->observers->add($observer);
  }

  /**
   * @inheritDoc
   */
  public function removeObserver(string|ObserverInterface $observer): void
  {
    $this->observers->removeAt($observer);
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    foreach ($this->observers as $observer)
    {
      $observer->onNotify($event);
    }
  }

  public function onFocus(EventInterface $event): void
  {
    // TODO: Implement onFocus() method.
  }

  public function onBlur(EventInterface $event): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public function getTop(): ?MenuGraphNodeInterface
  {
    return $this->topSibling;
  }

  /**
   * @inheritDoc
   */
  public function setTop(?MenuGraphNodeInterface $top): void
  {
    $this->topSibling = $top;
  }

  /**
   * @inheritDoc
   */
  public function getRight(): ?MenuGraphNodeInterface
  {
    return $this->rightSibling;
  }

  /**
   * @inheritDoc
   */
  public function setRight(?MenuGraphNodeInterface $right): void
  {
    $this->rightSibling = $right;
  }

  /**
   * @inheritDoc
   */
  public function getBottom(): ?MenuGraphNodeInterface
  {
    return $this->bottomSibling;
  }

  /**
   * @inheritDoc
   */
  public function setBottom(?MenuGraphNodeInterface $bottom): void
  {
    $this->bottomSibling = $bottom;
  }

  /**
   * @inheritDoc
   */
  public function getLeft(): ?MenuGraphNodeInterface
  {
    return $this->leftSibling;
  }

  /**
   * @inheritDoc
   */
  public function setLeft(?MenuGraphNodeInterface $left): void
  {
    $this->leftSibling = $left;
  }

  /**
   * @inheritDoc
   */
  public function getMenu(): ?MenuInterface
  {
    return $this;
  }
}