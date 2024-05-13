<?php

namespace Sendama\Engine\UI\Text;

use Amasiye\Figlet\Figlet;
use Exception;
use Sendama\Engine\Core\Scenes\Interfaces\SceneInterface;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\IO\Console\Console;
use Sendama\Engine\IO\Console\Cursor;
use Sendama\Engine\IO\Enumerations\Color;
use Sendama\Engine\UI\UIElement;

class Text extends UIElement
{
  /**
   * The text of the UI element.
   *
   * @var string
   */
  protected string $text = '';

  /**
   * The raw lines of the text.
   *
   * @var array
   */
  protected array $rawLines = [];

  /**
   * The color of the text.
   *
   * @var Color
   */
  protected Color $color = Color::WHITE;

  /**
   * The background color of the text.
   *
   * @var Color
   */
  protected Color $backgroundColor = Color::BLACK;

  /**
   * The font size of the text.
   *
   * @var int
   */
  protected int $fontSize = 12;

  /**
   * The font name of the text.
   *
   * @var string
   */
  protected string $fontName = 'basic';

  /**
   * A reference to the Figlet object.
   *
   * @var Figlet|null The reference to the Figlet object.
   */
  protected ?Figlet $figlet = null;

  /**
   * A reference to the cursor object.
   *
   * @var Cursor|null The reference to the cursor object.
   */
  protected ?Cursor $cursor = null;

  /**
   * @inheritDoc
   *
   * @throws Exception
   */
  public function __construct(
    SceneInterface $scene,
    string $name,
    Vector2 $position = new Vector2(0, 0),
    Vector2 $size = new Vector2(1, 1)
  )
  {
    parent::__construct($scene, $name, $position, $size);

    $this->cursor = Console::cursor();
    $this->figlet = new Figlet();
//    $this->figlet->setFont($this->getFontName());
    $this->figlet->setBackgroundColor(str_replace(' ', '_', strtolower($this->backgroundColor->getPhoneticName())));
    $this->figlet->setFontColor(str_replace(' ', '_', strtolower($this->color->getPhoneticName())));

    $this->rawLines = $this->getRawLines();
    Debug::log("Text '{$name}' created. - " . var_export($this->rawLines, true));
  }

  /**
   * Sets the text of the UI element.
   *
   * @param string $text The text of the UI element.
   * @return void
   * @throws Exception
   */
  public function setText(string $text): void
  {
    $this->text = $text;
    $this->rawLines = $this->getRawLines();
  }

  /**
   * Returns the text of the UI element.
   *
   * @return string The text of the UI element.
   */
  public function getText(): string
  {
    return $this->text;
  }

  /**
   * @inheritDoc
   *
   * @throws Exception
   */
  public function render(): void
  {
    $this->renderAt($this->position->getX(), $this->position->getY());
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    Console::writeLines($this->rawLines, $x, $y);
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->eraseAt($this->position->getX(), $this->position->getY());
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
   *
   * @throws Exception
   */
  public function start(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    // TODO: Implement update() method.

    // Handle text animation here
  }

  /**
   * Returns the raw lines of the text.
   *
   * @return array The raw lines of the text.
   * @throws Exception If the text is empty.
   */
  protected function getRawLines(): array
  {
    return explode("\n", $this->figlet?->render($this->getText()));
  }

  /**
   * Sets the font name of the text.
   *
   * @param string $fontName The font name of the text.
   * @return void
   */
  public function setFontName(string $fontName): void
  {
    $this->fontName = strtolower($fontName);
  }

  public function getFontName(): string
  {
    return strtolower($this->fontName);
  }

  public function get()
  {

  }
}