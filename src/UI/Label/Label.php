<?php

namespace Sendama\Engine\UI\Label;

use Sendama\Engine\UI\UIElement;

class Label extends UIElement
{
  protected string $text = '';

  public function getText(): string
  {
    return $this->text;
  }

  public function setText(string $text): void
  {
    $this->text = $text;
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->renderAt($this->position->getX(), $this->position->getY());
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement renderAt() method.
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->eraseAt($this->position->getX(), $this->position->getY());
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    $this->setText($this->name);
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    // TODO: Implement update() method.
  }
}