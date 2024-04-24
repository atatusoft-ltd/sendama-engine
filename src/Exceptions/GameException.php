<?php

namespace Sendama\Engine\Exceptions;

use Exception;
use Throwable;

/**
 * Represents a Game Exception.
 */
class GameException extends Exception
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