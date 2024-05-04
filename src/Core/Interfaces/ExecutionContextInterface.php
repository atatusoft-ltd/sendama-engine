<?php

namespace Sendama\Engine\Core\Interfaces;

interface ExecutionContextInterface
{
  /**
   * Returns a list of arguments.
   *
   * @return array<string, mixed> The list of arguments.
   */
  public function getArgs(): array;
}