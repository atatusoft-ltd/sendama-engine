<?php

namespace Sendama\Engine\Physics\Traits;

use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;

/**
 * Trait BoundTrait for getting the bounding box of a game object.
 *
 * @package Sendama\Engine\Physics\Traits
 */
trait BoundTrait
{
  /**
   * @inheritDoc
   */
  public function getBoundingBox(): Rect
  {
    $x =
      $this->getTransform()
        ->getPosition()
        ->getX() +
      $this->getGameObject()
        ->getSprite()
        ->getPivot()
        ->getX() -
      $this->getGameObject()
        ->getSprite()
        ->getRect()
        ->getX();
    $y =
      $this->getTransform()
        ->getPosition()
        ->getY() +
      $this->getGameObject()
        ->getSprite()
        ->getPivot()
        ->getY() -
      $this->getGameObject()
        ->getSprite()
        ->getRect()
        ->getY();
    return new Rect(
      new Vector2($x,$y),
      new Vector2(
        $this->getGameObject()->getSprite()->getRect()->getWidth(),
        $this->getGameObject()->getSprite()->getRect()->getHeight()
      )
    );
  }
}