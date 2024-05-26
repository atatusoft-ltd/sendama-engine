<?php

namespace Sendama\Engine\Physics\Interfaces;

interface TouchDetectionStrategyInterface
{
  /**
   * Checks if the collider is touching the given collider.
   *
   * @param ColliderInterface $collider The collider to check if it is touching.
   * @return bool True if the collider is touching the given collider, false otherwise.
   */
  public function isTouching(ColliderInterface $collider): bool;
}