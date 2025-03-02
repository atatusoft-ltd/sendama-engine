<?php

namespace Sendama\Engine\Exceptions;

use RuntimeException;

/**
 * Class NotImplementedException. Represents a not implemented exception.
 *
 * @package Sendama\Engine\Exceptions
 */
class NotImplementedException extends RuntimeException
{
  /**
   * NotImplementedException constructor.
   *
   * @param string $feature The feature that is not implemented.
   */
  public function __construct(string $feature)
  {
    parent::__construct("$feature is not implemented yet.");
  }
}