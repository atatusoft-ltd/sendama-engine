<?php

namespace Sendama\Examples\Collector\Scenes;

use Sendama\Engine\Core\Behaviours\SimpleBackListener;
use Sendama\Engine\Core\Behaviours\SimpleQuitListener;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Scenes\AbstractScene;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\UI\Menus\Menu;
use Sendama\Engine\UI\Menus\MenuItems\RangeControl;
use Sendama\Engine\UI\Windows\BorderPack;
use Sendama\Engine\Util\Path;

class SettingsScene extends AbstractScene
{
  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    // Create game objects
    $levelManager = new GameObject('Level Manager');
    $levelManager->addComponent(SimpleQuitListener::class);
    $levelManager->addComponent(SimpleBackListener::class);

    $settingsMenuWidth = 30;
    $settingsMenuHeight = DEFAULT_MENU_HEIGHT;

    Debug::log(var_export($this->settings, true));
    $leftMargin = round(DEFAULT_SCREEN_WIDTH / 2 - $settingsMenuWidth / 2);
    $topMargin = round(DEFAULT_SCREEN_HEIGHT / 2 - $settingsMenuHeight / 2);
    $settingsMenuBorderPack = new BorderPack(Path::join(Path::getAssetsDirectory(), 'border-packs', 'slim.border.php'));

    $settingsPosition = new Vector2($leftMargin, $topMargin);
    $settingsSize = new Vector2($settingsMenuWidth, $settingsMenuHeight);
    $settingsMenu = new Menu(
      'Settings',
      'b: Back',
      new Rect($settingsPosition, $settingsSize),
      borderPack: $settingsMenuBorderPack
    );

    $settingsMenu->addItem(
      new RangeControl('Music', 'Adjust the music volume', 0, null, 75, 0, 100),
    );
    $settingsMenu->addItem(
      new RangeControl('SFX', 'Adjust the music volume', 0, null, 75, 0, 100)
    );

    $this->add($levelManager);
    $this->add($settingsMenu);
  }
}