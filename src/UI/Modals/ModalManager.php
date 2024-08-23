<?php

namespace Sendama\Engine\UI\Modals;

use Assegai\Collections\Stack;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\UI\Modals\Interfaces\ModalInterface;
use Sendama\Engine\UI\Windows\Enumerations\WindowPosition;

/**
 * The Modal manager class is responsible for creating, managing and disposing of modals.
 *
 * @package Sendama\Engine\UI
 */
class ModalManager implements SingletonInterface, CanStart, CanUpdate, CanRender, CanResume
{
  /**
   * @var ModalManager|null $instance The instance of the modal manager.
   */
  protected static ?ModalManager $instance = null;

  /**
   * @var Stack<ModalInterface> $modals The stack of modals.
   */
  protected Stack $modals;

  public function __construct()
  {
    $this->modals = new Stack(ModalInterface::class);
  }

  /**
   * @inheritDoc
   *
   * @return self
   */
  public static function getInstance(): self
  {
    if (!self::$instance)
    {
      self::$instance = new self();
    }

    return self::$instance;
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
    $this->getCurrentModal()->render();
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
    $this->getCurrentModal()->erase();
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    // Do nothing.
  }

  public function update(): void
  {
    $this->getCurrentModal()->update();
  }

  /**
   * @return ModalInterface|null The current modal.
   */
  private function getCurrentModal(): ?ModalInterface
  {
    return $this->modals->peek();
  }

  /**
   * Displays an alert box with the specified message and an OK button.
   *
   * @param string $message The message to display.
   * @param string $title The title of the alert.
   * @param int $width The width of the alert.
   * @return void
   */
  public function alert(string $message, string $title = '', int $width = DEFAULT_DIALOG_WIDTH): void
  {
    $this->modals->push(new AlertModal($message, $title, $width));
    $this->modals->peek()->open();
    $this->modals->pop();
  }

  /**
   * Displays a confirmation box with the specified message and an OK and Cancel button.
   *
   * @param string $message The message to display.
   * @param string $title The title of the alert.
   * @param int $width The width of the alert.
   * @return bool The result of the confirmation.
   */
  public function confirm(string $message, string $title = '', int $width = DEFAULT_DIALOG_WIDTH): bool
  {
    $this->modals->push(new ConfirmModal($message, $title, $width));
    $result = $this->modals->peek()->open();
    $this->modals->pop();

    return (bool)$result;
  }

  /**
   * Displays a dialog box that prompts the user for input with specified message and an OK and Cancel button.
   *
   * @param string $message The message to display.
   * @param string $title The title of the alert.
   * @param string $default The default value of the prompt.
   * @param int $width The width of the alert.
   * @return string The result of the prompt.
   */
  public function prompt(string $message, string $title = '', string $default = '', int $width = DEFAULT_DIALOG_WIDTH): string
  {
    $modal = new PromptModal($message, $title, $default, $width);
    $modal->setContent($message);
    $this->modals->push($modal);

    return '';
  }

  /**
   * Displays a dialog box that prompts the user to select an option from a list of options.
   *
   * @param string $message The message to display.
   * @param array $options The options to display.
   * @param string $title The title of the dialog box.
   * @param int $default The default option.
   * @param Vector2|null $position
   * @param int $width The width of the dialog box.
   * @return int
   */
  public function select(
    string $message,
    array $options,
    string $title = '',
    int $default = 0,
    ?Vector2 $position = null,
    int $width = DEFAULT_SELECT_DIALOG_WIDTH
  ): int
  {
    $position = $position ?? new Vector2(0, 0);
    $this->modals->push(new SelectModal(
      $message,
      $options,
      $title,
      $default,
      $position->getX(),
      $position->getY(),
      $width
    ));
    $result = $this->modals->peek()->open();
    $this->modals->pop();

    return (int)$result;
  }

  /**
   * Displays a dialog box with a message.
   *
   * @param string $message The message to display.
   * @param string $title The title of the dialog box.
   * @param string $help The help text to display.
   * @param WindowPosition $position The position of the dialog box.
   * @param float $charactersPerSecond The number of characters to display per second.
   * @return void
   */
  public function showText(
    string $message,
    string $title = '',
    string $help = '',
    WindowPosition $position = WindowPosition::BOTTOM,
    float $charactersPerSecond = 1
  ): void
  {
    $this->modals->push(new TextBoxModal($message, $title, $help, $position, charactersPerSecond: $charactersPerSecond));
    $this->modals->peek()->open();
    $this->modals->pop();
  }
}