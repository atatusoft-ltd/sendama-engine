<?php

namespace Sendama\Engine\UI\Menus;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\UI\Interfaces\CanFocus;
use Sendama\Engine\UI\Menus\Interfaces\MenuInterface;

class MenuManager implements SingletonInterface, CanUpdate, CanResume, CanRender, CanFocus
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

  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  public function resume(): void
  {
    // TODO: Implement resume() method.
  }

  public function suspend(): void
  {
    // TODO: Implement suspend() method.
  }

  public function update(): void
  {
    // TODO: Implement update() method.
  }
}