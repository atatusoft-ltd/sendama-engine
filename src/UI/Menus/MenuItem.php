<?php

namespace Sendama\Engine\UI\Menus;

use Closure;
use PHPUnit\Framework\Constraint\Callback;
use Sendama\Engine\Core\Interfaces\ExecutionContextInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuItemInterface;

class MenuItem implements Interfaces\MenuItemInterface
{
  public function __construct(
    protected string   $label,
    protected string   $description = '',
    protected string   $icon = '',
    protected ?Closure $callback = null
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function execute(?ExecutionContextInterface $context = null): void
  {
    $this->callback?->call($context);
  }

  /**
   * @inheritDoc
   */
  public function getLabel(): string
  {
    return $this->label;
  }

  /**
   * @inheritDoc
   */
  public function setLabel(string $label): void
  {
    $this->label = $label;
  }

  /**
   * @inheritDoc
   */
  public function getIcon(): string
  {
    return $this->icon;
  }

  /**
   * @inheritDoc
   */
  public function setIcon(string $icon)
  {
    $this->icon = $icon;
  }

  /**
   * @inheritDoc
   */
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @inheritDoc
   */
  public function setDescription(string $description): void
  {
    $this->description = $description;
  }

  /**
   * Sets the callback to execute when the menu item is selected.
   *
   * @param Callback|null $callback The callback to execute when the menu item is selected.
   * @return void
   */
  public function setCallback(?Callback $callback): void
  {
    $this->callback = $callback;
  }

  /**
   * @inheritDoc
   */
  public function __toString(): string
  {
    return sprintf("%s %s", $this->icon, $this->label);
  }
}