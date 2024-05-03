<?php

namespace Sendama\Engine\UI\Menus;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuGraphNodeInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuManagerInterface;

class MenuManager implements SingletonInterface, MenuManagerInterface
{
  /**
   * @var MenuManager|null
   */
  protected static ?self $instance = null;

  /**
   * @var ItemList<MenuInterface> $menus
   */
  protected ItemList $menus;

  /**
   * @var MenuGraphNodeInterface|null $focused
   */
  protected MenuGraphNodeInterface|null $focused = null;

  /**
   * MenuManager constructor,
   */
  private function __construct()
  {
    // This is a singleton class
    $this->menus = new ItemList(MenuInterface::class);
  }

  /**
   * @inheritDoc
   *
   * @return self Returns the singleton MenuManager instance.
   */
  public static function getInstance(): self
  {
    if (! self::$instance )
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * @inheritDoc
   */
  public function focus(): void
  {
    // TODO: Implement focus() method.
  }

  /**
   * @inheritDoc
   */
  public function blur(): void
  {
    // TODO: Implement blur() method.
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {

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
    // Do nothing
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
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public function isFocused(MenuGraphNodeInterface $target): bool
  {
    return $this->focused === $target;
  }

  /**
   * @inheritDoc
   */
  public function getFocused(): MenuGraphNodeInterface|null
  {
    return $this->focused;
  }
}