<?php

namespace Sendama\Engine\Physics\Interfaces;

/**
 * Interface SimulatorInterface
 *
 * @package Sendama\Engine\Physics\Interfaces
 */
interface SimulatorInterface
{
  /**
   * Simulates the physics of the scene.
   *
   * @return void
   */
  public function simulate(): void;
}