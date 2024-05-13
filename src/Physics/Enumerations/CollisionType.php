<?php

namespace Sendama\Engine\Physics\Enumerations;

/**
 * Class CollisionType. Enumeration of collision types.
 *
 * @package Sendama\Engine\Physics\Enumerations
 */
enum CollisionType: int
{
  case NONE = 0;
  case COLLIDER = 1;
  case TRIGGER = 2;

  /**
   * Returns the collision type from a string.
   *
   * @param string $type The type as a string.
   * @return CollisionType The collision type.
   */
  public static function fromString(string $type): self
  {
    return match (strtolower($type)) {
      'collider' => self::COLLIDER,
      'trigger' => self::TRIGGER,
      default => self::NONE,
    };
  }
}
