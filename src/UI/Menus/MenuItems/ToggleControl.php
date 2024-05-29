<?php

namespace Sendama\Engine\UI\Menus\MenuItems;

use Closure;
use Sendama\Engine\UI\Menus\MenuItems\SelectControl;

class ToggleControl extends SelectControl
{
  /**
   * @param string $label
   * @param string $description
   * @param string $icon
   * @param Closure|null $callback
   * @param mixed $value
   * @param array $options
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