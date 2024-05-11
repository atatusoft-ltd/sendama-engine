<?php

namespace Sendama\Engine\Core\Interfaces;

use Sendama\Engine\Core\Sprite;
use Sendama\Engine\Core\Texture2D;
use Sendama\Engine\Core\Vector2;

/**
 * The GameObjectInterface
 */
interface GameObjectInterface extends CanCompare, CanResume, CanUpdate, CanStart, CanRender, ActivatableInterface
{
  /**
   * Sets the sprite of the game object
   *
   * @param Texture2D|array{path: string, width: ?int, height: ?int}|string $texture The path to the sprite texture.
   * @param Vector2 $position The position of the sprite
   * @param Vector2 $size
   * @return void
   */
  public function setSprite(Texture2D|array|string $texture, Vector2 $position, Vector2 $size): void;

  /**
   * Return the sprite set in the object's renderer.
   *
   * @return Sprite The sprite set in the object's renderer.
   */
  public function getSprite(): Sprite;
}