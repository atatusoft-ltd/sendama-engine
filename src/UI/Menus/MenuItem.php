<?php

namespace Sendama\Engine\UI\Menus;

use Sendama\Engine\Core\Interfaces\ExecutionContextInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuItemInterface;

class MenuItem implements Interfaces\MenuItemInterface
{
  public function __construct(
    protected string $label,
    protected string $description = '',
    protected string $icon = ''
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function execute(?ExecutionContextInterface $context = null): void
  {
    // TODO: Implement execute() method.
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
   * @inheritDoc
   */
  public function __toString(): string
  {
    return sprintf("%s %s", $this->icon, $this->label);
  }
}