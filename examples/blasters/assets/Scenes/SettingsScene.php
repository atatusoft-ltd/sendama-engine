<?php

namespace Sendama\Examples\Blasters\Scenes;

use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Scenes\AbstractScene;
use Sendama\Engine\Core\Scenes\SceneManager;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\UI\Menus\Menu;

class SettingsScene extends AbstractScene
{
  protected Menu $menu;

  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    $menuWidth = 20;
    $menuHeight = 8;

    $sceneManager = SceneManager::getInstance();
    $screenWidth = $this->screenWidth ?? $sceneManager->getSettings('screen_width');
    $screenHeight = $this->screenHeight ?? $sceneManager->getSettings('screen_height');

    $leftMargin = ($screenWidth / 2) - ($menuWidth / 2);
    $topMargin = ($screenHeight / 2) - ($menuHeight / 2);

    $this->menu = new Menu(
      'Settings',
      'b:back',
      new Rect(
        new Vector2((int)$leftMargin, (int)$topMargin),
        new Vector2($menuWidth, $menuHeight)
      ),
      cancelKey: [KeyCode::B, KeyCode::b, KeyCode::BACKSPACE],
      onCancel: fn() => loadPreviousScene()
    );

    $this->add($this->menu);
  }
}