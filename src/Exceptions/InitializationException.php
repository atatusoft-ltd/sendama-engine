<?php

namespace Sendama\Engine\Exceptions;

/**
 * Class InitializationException. Represents an exception that occurs during initialization.
 *
 * @package Sendama\Engine\Exceptions
 */
class InitializationException extends GameException
{
  public function __construct(string $reason)
  {
    parent::__construct("Initialization error: $reason");
  }
}