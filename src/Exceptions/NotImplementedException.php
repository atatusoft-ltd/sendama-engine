<?php

namespace Sendama\Engine\Exceptions;

use RuntimeException;

class NotImplementedException extends RuntimeException
{
  public function __construct(string $feature)
  {
    parent::__construct("$feature is not implemented yet.");
  }
}