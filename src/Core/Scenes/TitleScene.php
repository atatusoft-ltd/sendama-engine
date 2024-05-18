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
  /**
   * @var Text $titleText
   */
  protected Text $titleText;
  /**
   * @var int|null
   */
  protected ?int $screenWidth = null;
  /**
   * @var int|null
   */
  protected ?int $screenHeight = null;
  protected int $menuWidth = 20;
  protected int $menuHeight = 8;
  protected SceneManager $sceneManager;
  protected string $title = '';

  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    $this->sceneManager = SceneManager::getInstance();
    $gameName = getGameName() ?? $this->name;
    if (!$this->title)
    {
      $this->title = $gameName;
    }

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
        new Vector2($this->getMenuLeftMargin(), $this->getMenuTopMargin()),
        new Vector2($this->menuWidth, $this->menuHeight)
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

  /**
   * Returns the title of the game.
   *
   * @return string The title of the game.
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * Set the title of the game.
   *
   * @param string $title The title of the game.
   */
  public function setTitle(string $title): void
  {
    $this->title = $title;
  }

  public function setScreenDimensions(
    ?int $width = null,
    ?int $height = null,
  ): void
  {
    $this->screenWidth = $width;
    $this->screenHeight = $height;

  }

  /**
   * @return int
   */
  private function getMenuLeftMargin(): int
  {
    $screenWidth = $this->screenWidth ?? $this->sceneManager->getSettings('screen_width');
    return ($screenWidth / 2) - ($this->menuWidth / 2);
  }

  /**
   * @return int
   */
  private function getMenuTopMargin(): int
  {
    $screenHeight = $this->screenHeight ?? $this->sceneManager->getSettings('screen_height');
    return ($screenHeight / 2) - ($this->menuHeight / 2);
  }
}