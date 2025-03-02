<?php

namespace Sendama\Engine\Exceptions;

use Exception;

/**
 * Class SendamaException. Represents an exception in the Sendama engine.
 *
 * @package Sendama\Engine\Exceptions
 */
class SendamaException extends Exception
{
  public const int GENERAL = 0;
  public const int INVALID_ARGUMENT = 1;
  public const int NOT_FOUND = 2;
  public const int NOT_IMPLEMENTED = 3;
  public const int NOT_SUPPORTED = 4;
  public const int OUT_OF_BOUNDS = 5;
  public const int PERMISSION_DENIED = 6;
  public const int RUNTIME = 7;
}