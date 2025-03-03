<?php

namespace Sendama\Engine\Exceptions;

use Throwable;

/**
 * Class NotFoundException. Represents a not found exception.
 *
 * @package Sendama\Engine\Exceptions
 */
class NotFoundException extends GameException
{
  public function __construct(string $what, ?Throwable $previous = null)
  {
    parent::__construct("$what not found!", self::NOT_FOUND, $previous);
  }
}