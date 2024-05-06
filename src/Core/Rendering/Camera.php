<?php

namespace Sendama\Engine\Core\Rendering;

use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Rendering\Interfaces\CameraInterface;
use Sendama\Engine\Core\Transform;
use Sendama\Engine\Core\Vector2;

/**
 * Represents a camera.
 */
class Camera implements CameraInterface
{
  /**
   * @var Rect The viewport.
   */
  protected Rect $viewport;

  protected ?Transform $target = null;

  /**
   * Camera constructor.
   *
   * @param Vector2 $offset The offset.
   * @param float $zoom The zoom.
   * @param float $rotation The rotation.
   */
  public function __construct(
    protected SceneInterface $scene,
    protected Vector2 $offset = new Vector2(0, 0),
    protected float $zoom = 1.0,
    protected float $rotation = 0.0,
    protected int $width = DEFAULT_SCREEN_WIDTH,
    protected int $height = DEFAULT_SCREEN_HEIGHT
  )
  {
    $this->viewport = new Rect($this->offset, new Vector2($width, $height));
  }

  /**
   * @inheritDoc
   */
  public function getOffset(): Vector2
  {
    return $this->offset;
  }

  /**
   * @inheritDoc
   */
  public function setOffset(Vector2 $offset): void
  {
    $this->offset = $offset;
  }

  /**
   * @inheritDoc
   */
  public function getZoom(): float
  {
    return $this->zoom;
  }

  /**
   * @inheritDoc
   */
  public function setZoom(float $zoom): void
  {
    $this->zoom = $zoom;
  }

  /**
   * @inheritDoc
   */
  public function getRotation(): float
  {
    return $this->rotation;
  }

  /**
   * @inheritDoc
   */
  public function setRotation(float $rotation): void
  {
    $this->rotation = $rotation;
  }

  /**
   * @inheritDoc
   */
  public function getViewport(): Rect
  {
    return $this->viewport;
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    // TODO: Implement render() method.
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
    // TODO: Implement erase() method.
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
  public function update(): void
  {
    // TODO: Implement update() method.
  }

  /**
   * @inheritDoc
   */
  public function setViewport(Rect $viewport): void
  {
    $this->viewport = $viewport;
  }
}