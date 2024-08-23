<?php

namespace Sendama\Engine\UI\Modals;

use Assegai\Collections\Stack;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\UI\Modals\Interfaces\ModalInterface;

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
    $this->getCurrentModal()->render();
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement renderAt() method.
  }

  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  public function resume(): void
  {
    // TODO: Implement resume() method.
  }

  public function suspend(): void
  {
    // TODO: Implement suspend() method.
  }

  public function start(): void
  {
    // TODO: Implement start() method.
  }

  public function stop(): void
  {
    // TODO: Implement stop() method.
  }

  public function update(): void
  {
    // TODO: Implement update() method.
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
}