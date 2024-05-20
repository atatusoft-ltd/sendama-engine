<?php

namespace Sendama\Engine\Core\Scenes;

use Amasiye\Figlet\FontName;
use Exception;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\UI\Menus\Interfaces\MenuItemInterface;
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
      position: new Vector2(0, 4),
      size: new Vector2(DEFAULT_SCREEN_WIDTH, 5)
    );
    $this->titleText->setFontName(FontName::BIG->value);
    $this->titleText->setText($gameName);
    $textLeftMargin = ($this->sceneManager->getSettings('screen_width') / 2) - ($this->titleText->getWidth() / 2);
    $textTopMargin = 4;
    $this->titleText->setPosition(new Vector2(round($textLeftMargin), round($textTopMargin)));

    if (is_array($gameName))
    {
      $gameName = $_ENV['GAME_NAME'] ?? $this->name;
    }

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

  /**
   * Adds menu items to the menu.
   *
   * @param MenuItemInterface ...$item The menu items to add.
   * @return $this
   */
  public function addMenuItems(MenuItemInterface ...$item): self
  {
    foreach ($item as $menuItem)
    {
      $this->menu->addItem($menuItem);
    }

    return $this;
  }

  /**
   * Sets the font name of the title text.
   *
   * @param FontName|string $fontName The font name of the title text.
   * @return $this
   * @throws Exception
   */
  public function setTitleFont(FontName|string $fontName): self
  {
    $this->titleText->setFontName($fontName instanceof FontName ? $fontName->value : $fontName);
    return $this;
  }
}