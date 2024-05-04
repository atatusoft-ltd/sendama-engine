<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\Interfaces\SingletonInterface;

/**
 * Class Physics. Defines the global physics engine and its helper methods and properties.
 *
 * @package Sendama\Engine\Physics
 */
final class Physics implements SingletonInterface
{
  /**
   * @var self|null
   */
  protected static ?self $instance = null;
  /**
   * @var float The gravity applied to all rigid bodies in the scene.
   */
  protected float $gravity = 9.81;

  /**
   * Physics constructor.
   */
  private function __construct()
  {
    // This is a private constructor to prevent users from creating a new instance of the Physics class.
  }

  /**
   * @inheritDoc
   *
   * @return self
   */
  public static function getInstance(): self
  {
    if (self::$instance === null)
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Simulates the physics in the Scene.
   */
  public static function simulate(): void
  {

  }
}