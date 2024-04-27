<?php

namespace Sendama\Engine\Events;

use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Event;
use Sendama\Engine\IO\Enumerations\KeyCode;

/**
 * KeyboardEvent is the base class for all keyboard events.
 */
readonly class KeyboardEvent extends Event
{
  /**
   * KeyboardEvent constructor.
   *
   * @param string $key The key that was pressed.
   * @param bool $ctrlKey A boolean value indicating if the `Ctrl` key was pressed when the event was created.
   * @param bool $shiftKey A boolean value indicating if the `Shift` key was pressed when the event was created.
   * @param bool $altKey A boolean value indicating if the `Alt` key was pressed when the event was created.
   * @param bool $metaKey A boolean value indicating if the `Meta` key was pressed when the event was created.
   */
  public function __construct(
    private string $key,
    private bool   $ctrlKey = false,
    private bool   $shiftKey = false,
    private bool   $altKey = false,
    private bool   $metaKey = false,
  )
  {
    parent::__construct(type: EventType::KEYBOARD);
  }

  /**
   * Returns the key that was pressed.
   *
   * @return KeyCode|null The key that was pressed.
   */
  public function getKey(): ?KeyCode
  {
    return KeyCode::tryFrom($this->key);
  }

  /**
   * Returns a boolean value indicating if the `Ctrl` key was pressed when the event was created.
   *
   * @return bool A boolean value indicating if the `Ctrl` key was pressed when the event was created.
   */
  public function ctrlIsPressed(): bool
  {
    return $this->ctrlKey;
  }

  /**
   * Returns a boolean value indicating if the `Shift` key was pressed when the event was created.
   *
   * @return bool A boolean value indicating if the `Shift` key was pressed when the event was created.
   */
  public function shiftIsPressed(): bool
  {
    return $this->shiftKey;
  }

  /**
   * Returns a boolean value indicating if the `Alt` key was pressed when the event was created.
   *
   * @return bool A boolean value indicating if the `Alt` key was pressed when the event was created.
   */
  public function altIsPressed(): bool
  {
    return $this->altKey;
  }

  /**
   * Returns a boolean value indicating if the `Meta` key was pressed when the event was created.
   *
   * @return bool A boolean value indicating if the `Meta` key was pressed when the event was created.
   */
  public function metaIsPressed(): bool
  {
    return $this->metaKey;
  }

  /**
   * Returns a boolean value indicating if a modifier key such as `Alt`, `Shift`, `Ctrl`, or `Meta`, was pressed when
   * the event was created.
   *
   * @return bool A boolean value indicating if a modifier key such as `Alt`, `Shift`, `Ctrl`, or `Meta`, was pressed
   */
  public function hasModifier(): bool
  {
    return ($this->ctrlIsPressed() || $this->shiftIsPressed() || $this->altIsPressed() || $this->metaIsPressed());
  }
}