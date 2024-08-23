<?php

namespace Sendama\Engine\UI\Modals;

use Assegai\Collections\ItemList;
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
use Sendama\Engine\UI\Windows\Interfaces\BorderPackInterface;

/**
 * Class SelectModal. Represents a select modal.
 *
 * @package Sendama\Engine\UI\Modals
 */
class SelectModal implements ModalInterface
{
  /**
   * @var string[] $options The options.
   */
  protected array $options;
  /**
   * @var int $activeOptionIndex The active index.
   */
  protected int $activeOptionIndex = 0;
  /**
   * @var int $totalOptions The total options.
   */
  protected int $totalOptions = 0;
  /**
   * @var int $optionsOffset The options offset.
   */
  protected int $optionsOffset = 0;
  /**
   * @var string $title The title.
   */
  protected string $title;
  /**
   * @var string|null $help The help text.
   */
  protected ?string $help = 'c:cancel';
  /**
   * @var int $value The value.
   */
  protected int $value = -1;
  /**
   * @var bool $isShowing Whether the modal is showing.
   */
  protected bool $isShowing = false;
  /**
   * @var ItemList<ObserverInterface> $observers The observers.
   */
  protected ItemList $observers;
  /**
   * @var EventManager $eventManager The event manager.
   */
  protected EventManager $eventManager;
  /**
   * @var int $width The width.
   */
  protected int $titleLength = 0;
  /**
   * @var int $messageLength The message length.
   */
  protected int $messageLength = 0;
  /**
   * @var int $width The width.
   */
  protected int $helpLength = 0;

  /**
   * Constructs a new instance of SelectModal.
   *
   * @param string $message The message.
   * @param string[] $options The options.
   * @param string $title The title.
   * @param int $default The default option.
   * @param int|null $x The x position.
   * @param int|null $y The y position.
   * @param int|null $width The width.
   * @param int|null $height The height.
   * @param string|null $help The help text. Defaults to 'c:cancel'.
   * @param BorderPackInterface $borderPack The border pack. Defaults to DefaultBorderPack.
   */
  public function __construct(
    protected string $message,
    array $options,
    string $title = '',
    protected int $default = 0,
    protected ?int $x = null,
    protected ?int $y = null,
    protected ?int $width = DEFAULT_SELECT_DIALOG_WIDTH,
    protected ?int $height = null,
    ?string $help = 'c:cancel',
    protected BorderPackInterface $borderPack = new BorderPack('')
  )
  {
    $this->observers = new ItemList(ObserverInterface::class);
    $this->eventManager = EventManager::getInstance();
    $this->setOptions($options);
    $this->setTitle($title);
    $this->setHelp($help);
  }

  /**
   * Returns the options.
   *
   * @return string[] The options.
   */
  public function getOptions(): array
  {
    return $this->options;
  }

  /**
   * Sets the options.
   *
   * @param array $options The options.
   * @return void
   */
  public function setOptions(array $options): void
  {
    $this->options = $options;
    $totalOptions = 0;
    foreach ($this->options as $option)
    {
      $totalOptions++;
      $this->width = max($this->width, strlen($option) + 6);
    }
    $this->totalOptions = $totalOptions;
  }

  /**
   * Returns the height of the options.
   *
   * @return int The height of the options.
   */
  protected function getOptionsHeight(): int
  {
    return $this->totalOptions;
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
    $leftMargin = $this->x + ($x ?? 0);
    $topMargin = $this->y + ($y ?? 0);

    $this->erase($leftMargin, $topMargin);
    $this->renderTopBorder($leftMargin, $topMargin);
    $this->renderOptions($leftMargin, $topMargin + 1);
    $this->renderBottomBorder($leftMargin, $topMargin + $this->getModalHeight() - 1);
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
    $leftMargin = $this->x + ($x ?? 0);
    $topMargin = $this->y + ($y ?? 0);
    $modalHeight = max($this->height, $this->getModalHeight());

    for ($row = $topMargin; $row < $topMargin + $modalHeight; $row++) {
      Console::write(str_repeat(' ', $this->width), $leftMargin, $row);
    }
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    $v = Input::getAxis(AxisName::VERTICAL);

    if (abs($v) > 0) {
      if ($v > 0) {
        $this->activeOptionIndex = wrap($this->activeOptionIndex + 1, 0, $this->totalOptions - 1);
      } else {
        $this->activeOptionIndex = wrap($this->activeOptionIndex - 1, 0, $this->totalOptions - 1);
      }
    }

    if (Input::isKeyDown(KeyCode::ENTER)) {
      $this->value = $this->activeOptionIndex;
      $this->close();
    } else if (Input::isAnyKeyPressed([KeyCode::C, KeyCode::c])) {
      $this->cancel();
    }
  }

  /**
   * @inheritDoc
   */
  public function show(): void
  {
    $this->isShowing = true;
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::SHOW, true));
  }

  /**
   * @inheritDoc
   */
  public function hide(): void
  {
    $this->erase();
    $this->isShowing = false;
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::HIDE, true));
  }

  /**
   * @inheritDoc
   */
  public function open(): mixed
  {
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::OPEN, true));
    $this->show();
    $sleepTime = (int)(1000000 / 60);

    while ($this->isShowing) {
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
    $this->hide();
    $this->eventManager->dispatchEvent(new ModalEvent(ModalEventType::CLOSE, true));
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
    $this->titleLength = strlen($this->title);
  }

  /**
   * Returns the length of the title.
   *
   * @return int The length of the title.
   */
  protected function getTitleLength(): int
  {
    return $this->titleLength;
  }

  /**
   * @inheritDoc
   */
  public function getContent(): string
  {
    return $this->message . sprintf("\n\n%s", implode("\n", $this->options));
  }

  /**
   * @inheritDoc
   */
  public function setContent(string $content): void
  {
    $this->message = $content;
    $this->messageLength = strlen($this->message);
  }

  /**
   * Returns the modal help text.
   *
   * @return string The modal help text.
   */
  public function getHelp(): string
  {
    return $this->help;
  }

  /**
   * Sets the modal help text.
   *
   * @param string $help The modal help text.
   * @return void
   */
  public function setHelp(string $help): void
  {
    $this->help = $help;
    $this->helpLength = strlen($this->help);
  }

  /**
   * Returns the length of the help text.
   *
   * @return int The length of the help text.
   */
  public function getHelpLength(): int
  {
    return $this->helpLength;
  }

  /**
   * @inheritDoc
   */
  public function getButtons(): array
  {
    return $this->options;
  }

  /**
   * @inheritDoc
   */
  public function setButtons(array $buttons): void
  {
    $this->setOptions($buttons);
  }

  /**
   * @inheritDoc
   */
  public function getActiveButton(): string
  {
    return $this->options[$this->activeOptionIndex];
  }

  /**
   * @inheritDoc
   */
  public function setActiveButton(int $activeButtonIndex): void
  {
    $this->activeOptionIndex = $activeButtonIndex;
  }

  /**
   * @inheritDoc
   */
  public function getActiveIndex(): int
  {
    return $this->activeOptionIndex;
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
      $this->observers->add($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(string|StaticObserverInterface|ObserverInterface|null ...$observers): void
  {
    foreach ($observers as $observer) {
      $this->observers->remove($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    /** @var ObserverInterface $observer */
    foreach ($this->observers as $observer) {
      $observer->onNotify($this, $event);
    }
  }

  /**
   * Handles the input.
   *
   * @return void
   */
  protected function handleInput(): void
  {
    InputManager::handleInput();
  }

  /**
   * Renders the top border.
   *
   * @param int $x The x-position of the top border.
   * @param int $y The y-position of the top border.
   * @return void
   */
  protected function renderTopBorder(int $x, int $y): void
  {
    $output = $this->borderPack->getTopLeftCorner();
    $output .= $this->borderPack->getHorizontalBorder();
    $output .= $this->getTitle();
    $output .= str_repeat($this->borderPack->getHorizontalBorder(), $this->width - 3 - $this->getTitleLength());
    $output .= $this->borderPack->getTopRightCorner();

    Console::cursor()->moveTo($x, $y);
    echo $output;
  }

  /**
   * Renders the modal options.
   *
   * @param int $x The x-position of the options.
   * @param int $y The y-position of the top of the options.
   * @return void
   */
  protected function renderOptions(int $x, int $y): void
  {
    $topMargin = $y;
    $leftMargin = $x;
    $spacing = $this->width - 5;

    if ($this->message) {
      // TODO: Render the message above the options and separate them with a line.
    }

    foreach ($this->options as $optionIndex => $option) {
      $output = $this->borderPack->getVerticalBorder();
      $content = sprintf(" %s %-{$spacing}s", $optionIndex === $this->activeOptionIndex ? '>' : ' ', $option);

      if ($optionIndex === $this->activeOptionIndex) {
        $content = Color::apply(Color::BLUE, $content);
      }
      $output .= $content;
      $output .= $this->borderPack->getVerticalBorder();
      Console::cursor()->moveTo($leftMargin, $topMargin + $optionIndex);
      echo $output;
    }
  }

  /**
   * Render the bottom border.
   *
   * @param int $x The x-position of the bottom border.
   * @param int $y The y-position of the bottom border.
   * @return void
   */
  protected function renderBottomBorder(int $x, int $y): void
  {
    $output = $this->borderPack->getBottomLeftCorner();
    $output .= $this->borderPack->getHorizontalBorder();
    $output .= $this->help;
    $output .= str_repeat($this->borderPack->getHorizontalBorder(), $this->width - 3 - $this->getHelpLength());
    $output .= $this->borderPack->getBottomRightCorner();

    Console::cursor()->moveTo($x, $y);
    echo $output;
  }

  /**
   * Returns the total height of the modal.
   *
   * @return int The total height of the modal.
   */
  private function getModalHeight(): int
  {
    return $this->getOptionsHeight() + 2;
  }

  /**
   * Cancel the modal.
   *
   * @return void
   */
  protected function cancel(): void
  {
    $this->value = -1;
    $this->hide();
  }
}