<?php

namespace Sendama\Engine\Core;

class Transform extends Component
{
  /**
   * Transform constructor.
   *
   * @param GameObject $gameObject The game object.
   * @param Vector2 $position The position of the transform.
   * @param Vector2 $scale The scale of the transform.
   * @param Vector2 $rotation The rotation of the transform.
   * @param Transform|null $parent The parent of the transform.
   */
  public function __construct(
    GameObject $gameObject,
    protected Vector2 $position = new Vector2(0, 0),
    protected Vector2 $scale    = new Vector2(0, 0),
    protected Vector2 $rotation = new Vector2(0, 0),
    protected ?Transform $parent = null
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
  }

  /**
   * Sets the position of the transform.
   *
   * @param Vector2 $position The position of the transform.
   * @return void
   */
  public function setPosition(Vector2 $position): void
  {
    $this->position = $position;
  }

  /**
   * Sets the rotation of the transform.
   *
   * @param Vector2 $rotation The rotation of the transform.
   * @return void
   */
  public function setRotation(Vector2 $rotation): void
  {
    $this->rotation = $rotation;
  }

  /**
   * Sets the scale of the transform.
   *
   * @param Vector2 $scale The scale of the transform.
   * @return void
   */
  public function setScale(Vector2 $scale): void
  {
    $this->scale = $scale;
  }

  /**
   * Sets the parent of the transform.
   *
   * @param Transform|null $parent The parent of the transform.
   * @return void
   */
  public function setParent(?Transform $parent): void
  {
    $this->parent = $parent;
  }

  /**
   * Returns the parent of the transform.
   *
   * @return Transform|null The parent of the transform.
   */
  public function getParent(): ?Transform
  {
    return $this->parent;
  }
}