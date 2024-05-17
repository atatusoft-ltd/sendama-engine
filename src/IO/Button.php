<?php

namespace Sendama\Engine\IO;

use Sendama\Engine\IO\Enumerations\KeyCode;

/**
 * Button class. This class represents a button on a controller.
 *
 * @package Sendama\Engine\IO
 */
class Button
{
  /**
   * Button constructor.
   *
   * @param string $name The name of this button.
   * @param array<KeyCode> $positiveKeys The positive keys for this button.
   * @param array<KeyCode> $negativeKeys The negative keys for this button.
   */
  public function __construct(
    protected string  $name,
    protected array   $positiveKeys = [],
    protected array   $negativeKeys = [],
  )
  {
  }

  /**
   * Get the name of this button.
   *
   * @return string The name of this button.
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Set the name of this button.
   *
   * @param string $name The name of this button.
   * @return void
   */
  public function setName(string $name): void
  {
    $this->name = $name;
  }

  /**
   * Set the positive keys for this button.
   *
   * @param array<KeyCode> $positiveKeys The positive keys for this button.
   * @return void
   */
  public function setPositiveKeys(array $positiveKeys): void
  {
    $this->positiveKeys = $positiveKeys;
  }

  /**
   * Get the positive keys for this button.
   *
   * @return array<KeyCode> The positive keys for this button.
   */
  public function getPositiveKeys(): array
  {
    return $this->positiveKeys;
  }

  /**
   * Set the negative keys for this button.
   *
   * @param array<KeyCode> $negativeKeys The negative keys for this button.
   * @return void
   */
  public function setNegativeKeys(array $negativeKeys): void
  {
    $this->negativeKeys = $negativeKeys;
  }

  /**
   * Get the negative keys for this button.
   *
   * @return array<KeyCode> The negative keys for this button.
   */
  public function getNegativeKeys(): array
  {
    return $this->negativeKeys;
  }

  /**
   * Get the value of this button.
   *
   * @return float The value of this button.
   */
  public function getValue(): float
  {
    return match (true) {
      Input::isAnyKeyPressed($this->negativeKeys) => -1,
      Input::isAnyKeyPressed($this->positiveKeys) => 1,
      default => 0
    };
  }
}