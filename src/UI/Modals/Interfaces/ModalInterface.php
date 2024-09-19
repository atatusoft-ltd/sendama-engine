<?php

namespace Sendama\Engine\UI\Modals\Interfaces;

use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Events\Interfaces\ObservableInterface;

/**
 * Interface ModalInterface. Represents a modal.
 */
interface ModalInterface extends CanUpdate, CanRender, ObservableInterface, HelpfulInterface
{
  /**
   * Shows the modal.
   *
   * @return void
   */
  public function show(): void;

  /**
   * Hides the modal.
   *
   * @return void
   */
  public function hide(): void;

  /**
   * Opens the modal and returns the value when closed.
   *
   * @return mixed
   */
  public function open(): mixed;

  /**
   * Closes the modal and returns the value.
   *
   * @return mixed
   */
  public function close(): mixed;

  /**
   * Returns the modal's title.
   *
   * @return string The modal's title.
   */
  public function getTitle(): string;

  /**
   * Sets the modal's title.
   *
   * @param string $title The modal's title.
   * @return void
   */
  public function setTitle(string $title): void;

  /**
   * Returns the modal's content.
   *
   * @return string The modal's content.
   */
  public function getContent(): string;

  /**
   * Sets the modal's content.
   *
   * @param string $content The modal's content.
   * @return void
   */
  public function setContent(string $content): void;

  /**
   * Returns the modal's content as an array.
   *
   * @return string[] The modal's content as an array.
   */
  public function getButtons(): array;

  /**
   * Sets the modal's buttons.
   *
   * @param string[] $buttons The modal's buttons.
   * @return void
   */
  public function setButtons(array $buttons): void;

  /**
   * Returns the active button.
   *
   * @return string The active button.
   */
  public function getActiveButton(): string;

  /**
   * Sets the active button.
   *
   * @param int $activeButtonIndex The active button.
   * @return void
   */
  public function setActiveButton(int $activeButtonIndex): void;

  /**
   * Returns the active index.
   *
   * @return int The active index.
   */
  public function getActiveIndex(): int;

  /**
   * Returns the modal's value.
   *
   * @return mixed The modal's value.
   */
  public function getValue(): mixed;
}