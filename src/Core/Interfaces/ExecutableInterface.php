<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface ExecutableInterface. Represents an executable.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface ExecutableInterface
{
  /**
   * Executes the executable.
   *
   * @param ExecutionContextInterface|null $context The execution context.
   * @return void
   */
  public function execute(?ExecutionContextInterface $context = null): void;
}