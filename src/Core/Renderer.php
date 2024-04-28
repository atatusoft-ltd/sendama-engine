<?php

namespace Sendama\Engine\Core;

use Sendama\Engine\Core\Interfaces\CanRender;

class Renderer extends Component implements CanRender
{
  /**
   * Renderer constructor.
   *
   * @param GameObject $gameObject
   */
  public function __construct(GameObject $gameObject)
  {
    parent::__construct($gameObject);
  }

  public function render(): void
  {
    // TODO: Implement render() method.
  }

  public function renderAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement renderAt() method.
  }

  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }
}