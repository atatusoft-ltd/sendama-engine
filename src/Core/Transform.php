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
    Vector2 $position = new Vector2(0, 0),
    Vector2 $scale    = new Vector2(0, 0),
    Vector2 $rotation = new Vector2(0, 0),
  )
  {
    parent::__construct($gameObject);
  }
}