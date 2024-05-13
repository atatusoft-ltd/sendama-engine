<?php

namespace Sendama\Engine\Exceptions;

use Sendama\Engine\Exceptions\GameException;

/**
 * Represents a file not found exception.
 */
class FileNotFoundException extends GameException
{
  public function __construct(string $filename)
  {
    parent::__construct("File not found: $filename");
  }
}