<?php

namespace Sendama\Engine\UI\Label;

use Sendama\Engine\IO\Console\Console;
use Sendama\Engine\UI\UIElement;

/**
 * Represents a label UI element.
 *
 * @package Sendama\Engine\UI\Label
 */
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
    Console::write($this->text, $x, $y);
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
    $buffer = str_repeat(' ', strlen($this->text));
    Console::write($buffer, $x, $y);
  }

  public function awake(): void
  {
    $this->setText($this->name);
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    // Do nothing
  }
}