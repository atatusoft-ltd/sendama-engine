<?php

namespace Sendama\Engine\Exceptions;

/**
 * Represents a file not found exception.
 *
 * @package Sendama\Engine\Exceptions
 */
class FileNotFoundException extends GameException
{
  public function __construct(string $filename)
  {
    parent::__construct("File not found: $filename");
  }
}