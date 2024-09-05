<?php

namespace Sendama\Engine\UI\Menus\MenuItems;

use Closure;
use Sendama\Engine\UI\Menus\MenuItems\SelectControl;

/**
 * Class ToggleControl represents a toggle control.
 *
 * @package Sendama\Engine\UI\Menus\MenuItems
 */
class ToggleControl extends SelectControl
{
  /**
   * ToggleControl constructor.
   *
   * @param string $label
   * @param string $description
   * @param string $icon
   * @param Closure|null $callback
   * @param mixed $value
   * @param string $onLabel
   * @param string $offLabel
   * @param int $width
   */
  public function __construct(
    string                    $label,
    string                    $description = '',
    string                    $icon = '',
    ?Closure                  $callback = null,
    protected mixed           $value = 0,
    protected string          $onLabel = 'On',
    protected string          $offLabel = 'Off',
    protected int             $width = 10
  )
  {
    parent::__construct($label, $description, $icon, $callback, $value, [$this->onLabel, $this->offLabel], $width);
  }
}