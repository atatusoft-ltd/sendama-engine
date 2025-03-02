<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * The execution context interface. This interface is used to represent the execution context.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface ExecutionContextInterface
{
  /**
   * Returns a list of arguments.
   *
   * @return array<string, mixed> The list of arguments.
   */
  public function getArgs(): array;
}