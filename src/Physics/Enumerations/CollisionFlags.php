<?php

namespace Sendama\Engine\Physics\Enumerations;

/**
 * Class CollisionFlags. Enumeration of collision flags.
 *
 * @package Sendama\Engine\Physics\Enumerations
 */
enum CollisionFlags: int
{
  case None = 0;
  case Sides = 1;
  case Above = 2;
  case Below = 4;
}
