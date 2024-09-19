<?php

namespace Sendama\Engine\UI\Modals;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;
use Sendama\Engine\Events\ModalEvent;
use Sendama\Engine\IO\Console\Console;
use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Enumerations\Color;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;
use Sendama\Engine\IO\InputManager;
use Sendama\Engine\UI\Modals\Enumerations\ModalEventType;
use Sendama\Engine\UI\Modals\Interfaces\ModalInterface;
use Sendama\Engine\UI\Windows\BorderPack;
use Sendama\Engine\UI\Windows\Enumerations\HorizontalAlignment;
use Sendama\Engine\UI\Windows\Enumerations\VerticalAlignment;
use Sendama\Engine\UI\Windows\Interfaces\BorderPackInterface;
use Sendama\Engine\UI\Windows\Window;
use Sendama\Engine\UI\Windows\WindowAlignment;
use Sendama\Engine\UI\Windows\WindowPadding;

abstract class Modal implements ModalInterface
{
  /**
   * @var bool $showing Whether the modal is showing or not.
   */
  protected bool $showing = false;
  /**
   * @var int $activeIndex The active index of the modal.
   */
  protected int $activeIndex = 0;
  /**
   * @var ItemList<ObserverInterface> $observers The observers of the modal.
   */
  protected ItemList $observers;
  /**
   * @var ItemList<StaticObserverInterface> $staticObservers The static observers of the modal.
   */
  protected ItemList $staticObservers;
  /**
   * @var mixed $value The value of the modal.
   */
  protected mixed $value = null;
  /**
   * @var EventManager $eventManager The event manager.
   */
  protected EventManager $eventManager;
  /**
   * @var Window $window The window of the modal.
   */
  protected Window $window;
  /**
   * @var int $contentWidth The width of the content.
   */
  protected int $contentHeight = 0;
  /**
   * @var string $message The message of the modal.
   */
  protected string $message = '';
  /**
   * @var int $messageLength The length of the message.
   */
  protected int $messageLength = 0;
  /**
   * @var string[] $content The content of the modal.
   */
  protected array $content = [];
  /**
   * @var int $contentWidth The width of the content.
   */
  protected int $leftMargin = 0;
  /**
   * @var int $contentWidth The width of the content.
   */
  protected int $topMargin = 0;

  /**
   * @param string $message
   * @param string $title
   * @param int|null $x
   * @param int|null $y
   * @param int|null $width
   * @param int|null $height
   * @param string[] $buttons
   * @param string|null $help
   * @param BorderPackInterface $borderPack
   */
  public function __construct(
    string $message,
    protected string $title = '',
    protected ?int $x = null,
    protected ?int $y = null,
    protected ?int $width = null,
    protected ?int $height = null,
    protected array $buttons = ['OK'],
    protected ?string $help = 'c:cancel',
    protected BorderPackInterface $borderPack = new BorderPack('')
  )
  {
    $this->observers = new ItemList(ObserverInterface::class);
    $this->staticObservers = new ItemList(StaticObserverInterface::class);
    $this->eventManager = EventManager::getInstance();

    $alignment = new WindowAlignment(HorizontalAlignment::CENTER, VerticalAlignment::MIDDLE);
    $padding = new WindowPadding(rightPadding: 1, leftPadding: 1);

    $this->window = new Window(
      $this->title,
      $this->help ?? '',
      new Vector2($this->x ?? 0, $this->y ?? 0),
      $this->width ?? DEFAULT_DIALOG_WIDTH,
      $this->height ?? DEFAULT_DIALOG_HEIGHT,
      $this->borderPack,
      $alignment,
      $padding
    );
    $this->setContent($message);
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->renderAt();
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    Console::cursor()->moveTo($this->leftMargin + ($x ?? 0), $this->topMargin + ($y ?? 0));
    $this->renderTopBorder();
    Console::cursor()->moveTo($this->leftMargin + ($x ?? 0), $this->topMargin + 1 + ($y ?? 0));
    $this->renderContent();
    Console::cursor()->moveTo($this->leftMargin + ($x ?? 0), $this->topMargin + 1 + $this->getContentHeight() + ($y ?? 0));
    $this->renderButtons();
    Console::cursor()->moveTo($this->leftMargin + ($x ?? 0), $this->topMargin + 1 + $this->getContentHeight() + 1 + ($y ?? 0));
    $this->renderBottomBorder();
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->eraseAt();
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    $height = max($this->height ?? 0, $this->getContentHeight() + 3);
    $leftMargin = (int) ( (DEFAULT_SCREEN_WIDTH / 2) - ($this->width / 2) + ($x ?? 0) );
    $topMargin = (int) ( (DEFAULT_SCREEN_HEIGHT / 2) - ($this->height / 2) + ($y ?? 0) );

    for ($row = 0; $row < $height; $row++) {
      Console::cursor()->moveTo($leftMargin + ($this->x ?? 0), $topMargin + $row + ($this->y ?? 0));
      echo str_repeat(' ', $this->width ?? 0);
    }
  }

  /**
   * Processes the input.
   *
   * @return void
   */
  protected function handleInput(): void
  {
    InputManager::handleInput();
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    $h = Input::getAxis(AxisName::HORIZONTAL);

    if (abs($h) > 0) {

      if ($h < 0) {
        $this->activeIndex = wrap($this->activeIndex - 1, 0, count($this->buttons) - 1);
      } else {
        $this->activeIndex = wrap($this->activeIndex + 1, 0, count($this->buttons) - 1);
      }
    }

    if (Input::isKeyDown(KeyCode::ENTER)) {
      $this->submit();
    }

    if (Input::isAnyKeyPressed([KeyCode::C, KeyCode::c])) {
      $this->cancel();
    }
  }

  /**
   * @inheritDoc
   */
  public function show(): void
  {
    $this->showing = true;
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::SHOW, true));
  }

  /**
   * @inheritDoc
   */
  public function hide(): void
  {
    $this->erase();
    $this->showing = false;
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::HIDE, true));
  }

  /**
   * @inheritDoc
   */
  public function open(): mixed
  {
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::OPEN, true));
    $this->leftMargin = (int)( (DEFAULT_SCREEN_WIDTH / 2) - ($this->width / 2) );
    $this->topMargin = (int)( (DEFAULT_SCREEN_HEIGHT / 2) - ($this->height / 2) );
    $this->show();
    $sleepTime = (int)(1000000 / 60);

    while ($this->showing) {
      $this->handleInput();
      $this->update();
      $this->render();

      usleep($sleepTime);
    }

    return $this->close();
  }

  /**
   * @inheritDoc
   */
  public function close(): mixed
  {
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::CLOSE, $this->getValue()));
    $this->hide();
    return $this->getValue();
  }

  /**
   * @inheritDoc
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @inheritDoc
   */
  public function setTitle(string $title): void
  {
    $this->title = $title;
  }

  /**
   * @inheritDoc
   */
  public function getContent(): string
  {
    return $this->message;
  }

  /**
   * @inheritDoc
   */
  public function setContent(string $content): void
  {
    $this->message = $content;
    $this->messageLength = strlen($this->message);
    $this->content = explode("\n", $content);
    $this->calculateContentHeight();
  }

  /**
   * @inheritDoc
   */
  public function getButtons(): array
  {
    return $this->buttons;
  }

  /**
   * @inheritDoc
   */
  public function setButtons(array $buttons): void
  {
    $this->buttons = $buttons;
  }

  /**
   * @inheritDoc
   */
  public function getActiveButton(): string
  {
    return $this->buttons[$this->activeIndex];
  }

  /**
   * @inheritDoc
   */
  public function setActiveButton(int $activeButtonIndex): void
  {
    $this->activeIndex = $activeButtonIndex;
  }

  /**
   * @inheritDoc
   */
  public function getActiveIndex(): int
  {
    return $this->activeIndex;
  }

  /**
   * @inheritDoc
   */
  public function getHelp(): string
  {
    return $this->help ?? '';
  }

  /**
   * @inheritDoc
   */
  public function setHelp(string $help): void
  {
    $this->help = $help;
  }

  /**
   * @inheritDoc
   */
  public function getHelpLength(): int
  {
    return strlen($this->getHelp());
  }

  /**
   * @inheritDoc
   */
  public function getValue(): mixed
  {
    return $this->value;
  }

  /**
   * @inheritDoc
   */
  public function addObservers(string|StaticObserverInterface|ObserverInterface ...$observers): void
  {
    foreach ($observers as $observer) {
      if (is_object($observer)) {
        if (get_class($observer) === ObserverInterface::class) {
          $this->observers->add($observer);
        }

        if (get_class($observer) === StaticObserverInterface::class) {
          $this->staticObservers->add($observer);
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(string|StaticObserverInterface|ObserverInterface|null ...$observers): void
  {
    foreach ($observers as $observer) {
      if (is_object($observer)) {
        if (get_class($observer) === ObserverInterface::class) {
          $this->observers->remove($observer);
        }

        if (get_class($observer) === StaticObserverInterface::class) {
          $this->staticObservers->remove($observer);
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    foreach ($this->observers as $observer) {
      /** @var ObserverInterface $observer */
      $observer->onNotify($this, $event);
    }

    foreach ($this->staticObservers as $observer) {
      /** @var StaticObserverInterface $observer */
      $observer::onNotify($this, $event);
    }
  }

  /**
   * Renders the top border.
   *
   * @return void
   */
  protected function renderTopBorder(): void
  {
    $titleLength = strlen($this->title);
    $horizontalBorder = str_repeat($this->borderPack->getHorizontalBorder(), $this->width - $titleLength - 3);
    echo $this->borderPack->getTopLeftCorner() .
      $this->borderPack->getHorizontalBorder() .
      $this->title .
      $horizontalBorder .
      $this->borderPack->getTopRightCorner();
  }

  /**
   * Renders the content.
   *
   * @return void
   */
  protected function renderContent(): void
  {
    foreach ($this->content as $line) {
      echo $this->borderPack->getVerticalBorder() .
        str_pad($line, $this->width - 2, ' ', STR_PAD_BOTH) .
        $this->borderPack->getVerticalBorder();
    }
  }

  /**
   * Renders the buttons.
   *
   * @return void
   */
  protected function renderButtons(): void
  {
    $activeColor = Color::BLUE;
    $buttonOutput = implode(' ', $this->buttons);
    $buttonOutputLength = strlen($buttonOutput);
    $padding = (int) (($this->width - 2 - $buttonOutputLength) / 2);
    $output = str_repeat(' ', $padding) . $buttonOutput . str_repeat(' ', $padding);
    if (strlen($output) % 2 !== 0) {
      $output .= ' ';
    }

    $output =
      $this->borderPack->getVerticalBorder() .
      str_replace($this->buttons[$this->activeIndex] ?? '', Color::apply($activeColor, $this->buttons[$this->activeIndex] ?? ''), $output) .
      $this->borderPack->getVerticalBorder();
    echo $output;
  }

  /**
   * Renders the bottom border of the modal.
   *
   * @return void
   */
  protected function renderBottomBorder(): void
  {
    $horizontalBorder = str_repeat($this->borderPack->getHorizontalBorder(), $this->width - $this->getHelpLength() - 3);
    $output = $this->borderPack->getBottomLeftCorner() .
      $this->borderPack->getHorizontalBorder() .
      $this->help .
      $horizontalBorder .
      $this->borderPack->getBottomRightCorner();
    echo $output;
  }

  /**
   * Returns the height of the content.
   *
   * @return int The height of the content.
   */
  protected function getContentHeight(): int
  {
    return $this->contentHeight;
  }

  /**
   * Submits the modal. This is called when the user presses the enter key.
   *
   * @return void
   */
  protected function submit(): void
  {
    $this->value = $this->buttons[$this->activeIndex];
    $this->hide();
  }

  /**
   * Hides the modal.
   *
   * @return void
   */
  protected function cancel(): void
  {
    $this->value = null;
    $this->hide();
  }

  /**
   * Calculates the height of the content.
   *
   * @return void
   */
  protected function calculateContentHeight(): void
  {
    $this->contentHeight = count(explode("\n", $this->message));
  }
}