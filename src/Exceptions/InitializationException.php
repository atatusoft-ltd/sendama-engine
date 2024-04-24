<?php

namespace Sendama\Engine\Exceptions;

use Sendama\Engine\Exceptions\GameException;

class InitializationException extends GameException
{
  public function __construct(string $reason)
  {
    parent::__construct("Initialization error: $reason");
  }
}