<?php

namespace Sendama\Engine\Exceptions;

use Exception;
use Throwable;

/**
 * Represents a Game Exception.
 *
 * @package Sendama\Engine\Exceptions
 */
class GameException extends SendamaException
{
  /**
   * @inheritDoc
   */
  public function __construct(
    string     $message,
    int        $code = 0,
    ?Throwable $previous = null,
  )
  {
    $namespaceParts = explode('\\', __CLASS__);
    $tag = end($namespaceParts) ?? __CLASS__;

    parent::__construct("[$tag] $message", $code, $previous);
  }
}