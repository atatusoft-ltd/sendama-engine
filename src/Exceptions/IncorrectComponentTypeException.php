<?php

namespace Sendama\Engine\Exceptions;

use Throwable;

/**
 * IncorrectComponentTypeException class.
 *
 * This exception is thrown when a component of an incorrect type is found.
 *
 * @package Sendama\Engine\Exceptions
 */
class IncorrectComponentTypeException extends SendamaException
{
  /**
   * @param class-string $actual The actual component type.
   * @param class-string $expected The expected component type.
   * @param Throwable|null $previous The previous exception.
   */
  public function __construct(string $actual, string $expected, Throwable $previous = null)
  {
    parent::__construct("Found component of type $actual instead of $expected.", previous: $previous);
  }
}