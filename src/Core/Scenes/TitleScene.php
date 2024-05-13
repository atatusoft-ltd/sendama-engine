<?php

namespace Sendama\Engine\Core\Scenes;

use Exception;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\UI\Menus\Menu;
use Sendama\Engine\UI\Menus\MenuItem;
use Sendama\Engine\UI\Text\Text;

class TitleScene extends AbstractScene
{
  /**
   * @var Menu $menu
   */
  protected Menu $menu;

  protected Text $titleText;

  /**
   * @inheritDoc
   *
   * @throws Exception
   */
  public function __construct(
    string $name = 'Title Scene',
    protected ?int $screenWidth = null,
    protected ?int $screenHeight = null
  )
  {
    parent::__construct($name);
  }

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
    $gameName = getGameName() ?? $this->name;

    $this->titleText = new Text(
      scene: $this,
      name: $gameName,
      position: new Vector2(0, 0),
      size: new Vector2(DEFAULT_SCREEN_WIDTH, 5)
    );
    $this->titleText->setText($gameName);
    $this->titleText->setFontName('basic');

    if (is_array($gameName))
    {
      $gameName = $_ENV['GAME_NAME'] ?? $this->name;
    }

    $this->titleText = new Text(
      scene: $this,
      name: $gameName,
      position: new Vector2(0, 0),
      size: new Vector2(DEFAULT_SCREEN_WIDTH, 5)
    );

    $this->menu = new Menu(
      title: $gameName,
      description: 'q:quit',
      dimensions: new Rect(
        new Vector2((int)$leftMargin, (int)$topMargin),
        new Vector2($menuWidth, $menuHeight)
      ),
      cancelKey: [KeyCode::Q, KeyCode::q],
      onCancel: fn() => quitGame()
    );
    $this->menu->addItem(new MenuItem(
      label: 'New Game',
      description: 'Start a new game',
      icon: '🎮',
      callback: function () {
        loadScene(1);
      }
    ));
    $this->menu->addItem(new MenuItem(
      'High Scores',
      'View the high scores',
      '🏆',
      function () {
        loadScene('High Scores');
      }
    ));
    $this->menu->addItem(new MenuItem(
      label: 'Settings',
      description: 'Change the game settings',
      icon: '⚙️',
      callback: function () {
        loadScene('Settings');
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

    $this->add($this->titleText);
    $this->add($this->menu);
  }
}