<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\UI\Menus\Menu;
use Sendama\Engine\UI\Menus\MenuItem;

class TitleScene extends AbstractScene
{
  /**
   * @var Menu $menu
   */
  protected Menu $menu;

  public function __construct(?string $name = null)
  {
    parent::__construct($name ?? 'Title Scene');

    $menuWidth = DEFAULT_MENU_WIDTH;
    $menuHeight = DEFAULT_MENU_HEIGHT;

    $leftMargin = (DEFAULT_SCREEN_WIDTH / 2) - ($menuWidth / 2);
    $topMargin = (DEFAULT_SCREEN_HEIGHT / 2) - ($menuHeight / 2);

    $this->menu = new Menu(
      'Main Menu',
      'q:quit',
      new Rect(
        new Vector2((int)$leftMargin, (int)$topMargin),
        new Vector2($menuWidth, $menuHeight)
      )
    );
    $this->menu->addItem(new MenuItem(
      label: 'New Game',
      description: 'Start a new game',
      icon: '🎮',
      callback: function () {
        loadScene('GameScene');
      }
    ));
    $this->menu->addItem(new MenuItem(
      label: 'Quit',
      description: 'Quit the game',
      icon: '🚪',
      callback: function () {
        quitGame();
      }
    ));

    $this->add($this->menu);
  }
}