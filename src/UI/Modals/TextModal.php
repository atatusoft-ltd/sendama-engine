<?php

namespace Sendama\Engine\UI\Modals;

use Override;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;
use Sendama\Engine\UI\Windows\BorderPack;
use Sendama\Engine\UI\Windows\Enumerations\WindowPosition;
use Sendama\Engine\UI\Windows\Interfaces\BorderPackInterface;
use Sendama\Engine\UI\Windows\Window;

/**
 * This class represents a modal that displays a message in a text box.
 *
 * @package Sendama\Engine\UI\Modals
 */
class TextModal extends Modal
{
  /**
   * @var bool Whether the text is currently being printed.
   */
  protected bool $isPrinting = false;
  /**
   * @var int The current character index.
   */
  protected int $currentCharacterIndex = 0;
  /**
   * @var int The total number of lines of content.
   */
  protected int $totalLinesOfContent = 0;
  /**
   * @var Window The window to display the text in.
   */
  protected Window $window;
  /**
   * @var float The next time to print a character.
   */
  protected float $nextPrintTime = 0;

  /**
   * TextBoxModal constructor.
   *
   * @param string $message The message to display.
   * @param string $title The title of the modal.
   * @param string $help The help text to display.
   * @param WindowPosition $position The position of the modal.
   * @param BorderPackInterface $borderPack The border pack to use.
   * @param float $charactersPerSecond The number of characters to print per second.
   */
  public function __construct(
    string $message,
    string $title = '',
    string $help = '',
    WindowPosition $position = WindowPosition::BOTTOM,
    protected BorderPackInterface $borderPack = new BorderPack(''),
    protected float $charactersPerSecond = 60
  )
  {
    $width = DEFAULT_WINDOW_WIDTH;
    $height = 5;
    $positionCoordinates = $position->getCoordinates($width, $height);

    parent::__construct(
      $message,
      $title,
      $positionCoordinates->getX(),
      $positionCoordinates->getY(),
      $width,
      $height,
      buttons: [],
      help: $help
    );

    $this->window = new Window(
      $title,
      $help,
      $positionCoordinates,
      $width,
      $height
    );
  }

  /**
   * @inheritDoc
   */
  #[Override]
  public function setHelp(string $help): void
  {
    parent::setHelp($help);
    $this->window->setHelp($help);
  }

  /**
   * @inheritDoc
   */
  public function show(): void
  {
    parent::show();
    $this->leftMargin = $this->x ?? 0;
    $this->topMargin = $this->y ?? 0;
    $this->isPrinting = true;

    $this->updateContent();
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    parent::update();

    if ($this->isPrinting) {
      $this->updateContent();
    }

    if (Input::isKeyDown(KeyCode::SPACE)) {
      $this->submit();
    }
  }

  /**
   * Updates the content of the window.
   *
   * @return void
   */
  public function updateContent(): void
  {
    if ($this->isPrinting) {
      $this->content = $this->convertMessageToLinesOfContent($this->message);

      // Calculate the number of lines.
      $this->totalLinesOfContent = count($this->content);
      $verticalPadding = $this->height - $this->totalLinesOfContent - 2; // We subtract 2 because of the top and bottom borders.

      for ($row = 0; $row < $verticalPadding; $row++) {
        $this->content[] = '';
      }

      $now = microtime(true);
      if ($now >= $this->nextPrintTime) {
        $this->nextPrintTime = $now + (1 / $this->charactersPerSecond);
        $this->currentCharacterIndex++;
      }

      $this->isPrinting = $this->currentCharacterIndex < $this->messageLength;

      $this->window->setContent($this->content);
    } else {
      $this->setHelp('space:continue');
    }
  }

  /**
   * @inheritDoc
   */
  public function render(?int $x = null, ?int $y = null): void
  {
    $this->window->renderAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function erase(?int $x = null, ?int $y = null): void
  {
    $this->window->eraseAt($x, $y);
  }

  protected function submit(): void
  {
    if ($this->isPrinting)
    {
      $this->currentCharacterIndex = $this->messageLength;
    }
    else
    {
      $this->cancel();
    }
  }

  /**
   * Converts the message to lines of content.
   *
   * @param string $message
   * @return string[] The lines of content.
   */
  protected function convertMessageToLinesOfContent(string $message): array
  {
    // Split the message into lines.
    $contentString = wordwrap($message, $this->width - 2, "\n", true);
    return explode("\n", substr($contentString, 0, $this->currentCharacterIndex));
  }
}