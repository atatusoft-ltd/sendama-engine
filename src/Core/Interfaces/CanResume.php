<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Defines the contract for a class that can be resumed and suspended.
 */
interface CanResume
{
  /**
   * Resumes the class.
   */
  public function resume(): void;

  /**
   * Suspends the class.
   */
  public function suspend(): void;
}