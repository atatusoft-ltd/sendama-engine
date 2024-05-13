<?php

namespace Sendama\Engine\Core\Rendering\Interfaces;

use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;

/**
 * Represents a camera.
 *
 * @package Sendama\Engine\Rendering\Interfaces
 */
interface CameraInterface extends CanRender, CanUpdate
{
  /**
   * Returns the offset.
   *
   * @return Vector2 The offset.
   */
  public function getOffset(): Vector2;

  /**
   * Sets the offset.
   *
   * @param Vector2 $offset The offset.
   */
  public function setOffset(Vector2 $offset): void;

  /**
   * Returns the zoom.
   *
   * @return float The zoom.
   */
  public function getZoom(): float;

  /**
   * Sets the zoom.
   *
   * @param float $zoom The zoom.
   */
  public function setZoom(float $zoom): void;

  /**
   * Returns the rotation.
   *
   * @return float The rotation.
   */
  public function getRotation(): float;

  /**
   * Sets the rotation.
   *
   * @param float $rotation The rotation.
   */
  public function setRotation(float $rotation): void;

  /**
   * Returns the viewport.
   *
   * @return Rect The viewport.
   */
  public function getViewport(): Rect;

  /**
   * Sets the viewport.
   *
   * @param Rect $viewport The viewport.
   */
  public function setViewport(Rect $viewport): void;

  /**
   * Clears the screen. This method clears the screen without calling 
   * the erase method on each scene object.
   *
   * @return void
   */
  public function clearScreen(): void;

  /**
   * Renders the entire world space.
   *
   * @return void
   */
  public function renderWorldSpace(): void;
}