<?php

namespace Sendama\Engine\UI\Menus\MenuItems;

use Closure;
use Sendama\Engine\UI\Menus\MenuItems\AbstractMenuControl;

class SelectControl extends AbstractMenuControl
{
  /**
   * The index of the selected option.
   *
   * @var int
   */
  protected int $selectedIndex = 0;
  /**
   * The total number of options.
   *
   * @var int
   */
  protected int $totalOptions = 0;
  /**
   * SelectControl constructor.
   *
   * @inheritDoc
   * @param array<string> $options The list of options.
   * @param int $width The width of the control.
   */
  public function __construct(
    string                    $label,
    string                    $description = '',
    string                    $icon = '',
    ?Closure                  $callback = null,
    protected mixed           $value = 0,
    protected array           $options = [],
    protected int             $width = 10
  )
  {
    parent::__construct($label, $description, $icon, $callback);
    $this->totalOptions = count($this->options);
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
    $this->selectedIndex = wrap($this->selectedIndex + $direction, 0, $this->totalOptions - 1);
  }

  /**
   * @inheritDoc
   */
  public function __toString(): string
  {
    $spacing = $this->width - strlen($this->label) - 1;
    return sprintf(
      "%s %{$spacing}s",
      $this->label,
      $this->options[$this->selectedIndex]
    );
  }
}