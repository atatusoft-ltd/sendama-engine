<?php

namespace Sendama\Engine\Core;

class Transform extends Component
{
  /**
   * Transform constructor.
   *
   * @param GameObject $gameObject
   * @param Vector2    $position
   * @param Vector2    $scale
   * @param Vector2    $rotation
   */
  public function __construct(
    GameObject $gameObject,
    protected Vector2 $position = new Vector2(0, 0),
    protected Vector2 $scale    = new Vector2(0, 0),
    protected Vector2 $rotation = new Vector2(0, 0),
  )
  {
    parent::__construct($gameObject);
  }

  /**
   * Returns the position of the transform.
   *
   * @return Vector2 The position of the transform.
   */
  public function getPosition(): Vector2
  {
    return $this->position;
  }

  /**
   * Returns the scale of the transform.
   *
   * @return Vector2 The scale of the transform.
   */
  public function getScale(): Vector2
  {
    return $this->scale;
  }

  /**
   * Returns the rotation of the transform.
   *
   * @return Vector2 The rotation of the transform.
   */
  public function getRotation(): Vector2
  {
    return $this->rotation;
  }

  /**
   * Moves the transform in direction and distance specified by translation.
   *
   * @param Vector2 $translation The translation to apply to the transform.
   * @return void
   */
  public function translate(Vector2 $translation): void
  {
    $this->gameObject->getRenderer()->erase();
    $this->position->add($translation);
    // TODO: Remove this code
//    $this->gameObject->getRenderer()->update();
  }
}