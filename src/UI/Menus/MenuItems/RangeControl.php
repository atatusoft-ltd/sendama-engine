<?php

namespace Sendama\Engine\UI\Menus\MenuItems;

use Closure;

/**
 * The class RangeControl. Represents a control that allows the user to select a value within a range.
 *
 * @package Sendama\Engine\UI\Menus
 */
class RangeControl extends AbstractMenuControl
{
  /**
   * The RangeControl constructor.
   *
   * @inheritDoc
   * @param int $min The minimum value.
   * @param int $max The maximum value.
   * @param int $step The step value. Specifies the increment or decrement value.
   * @param int $width The width of the control.
   */
  public final function __construct(
    string              $label,
    string              $description = '',
    string              $icon = '',
    ?Closure            $callback = null,
    protected mixed     $value = 0,
    protected int       $min = 0,
    protected int       $max = 100,
    protected int       $step = 1,
    protected int       $width = 100,
  )
  {
    parent::__construct($label, $description, $icon, $callback, $value);
  }

  /**
   * @inheritDoc
   */
  public function onVerticalInput(int $direction): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public function onHorizontalInput(int $direction): void
  {
    $value = $direction > 0 ? $this->value + $this->step : $this->value - $this->step;
    $this->value = clamp($value, $this->min, $this->max);
  }

  /**
   * @inheritDoc
   */
  public function __toString(): string
  {
    $spacing = $this->width - strlen($this->label) - 1;
    return sprintf("%s %{$spacing}s", $this->label, $this->value);
  }
}