<?php

namespace Sendama\Engine\IO;

use Sendama\Engine\IO\Enumerations\KeyCode;

class VirtualAxis
{
  /**
   * Build a new virtual axis.
   *
   * @param string $name The name of the axis.
   * @param KeyCode[] $negativeButtons The negative buttons.
   * @param KeyCode[] $positiveButtons The positive buttons.
   */
  public function __construct(
    protected string $name,
    protected array $negativeButtons = [],
    protected array $positiveButtons = [],
  )
  {
  }

  /**
   * Returns the name of the virtual axis.
   *
   * @return string The name of the virtual axis.
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Returns the value of the virtual axis.
   *
   * @return float The value of the virtual axis.
   */
  public function getValue(): float
  {
    return match (true) {
      Input::isAnyKeyPressed($this->negativeButtons) => -1,
      Input::isAnyKeyPressed($this->positiveButtons) => 1,
      default => 0
    };
  }
}