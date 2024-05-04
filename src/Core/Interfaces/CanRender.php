<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * The interface CanRender. Represents an object that can be rendered and erased.
 */
interface CanRender
{
  /**
   * Renders the object.
   *
   * @return void
   */
  public function render(): void;

  /**
   * Renders the object at the given coordinates.
   *
   * @param int|null $x The X coordinate or offset of the object.
   * @param int|null $y The Y coordinate or offset of the object.
   * @return void
   */
  public function renderAt(?int $x = null, ?int $y = null): void;

  /**
   * Erases the object.
   *
   * @return void
   */
  public function erase(): void;

  /**
   * Erases the object at the given coordinates.
   *
   * @param int|null $x The X coordinate or offset of the object.
   * @param int|null $y The Y coordinate or offset of the object.
   * @return void
   */
  public function eraseAt(?int $x = null, ?int $y = null): void;
}