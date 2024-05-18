<?php

namespace Sendama\Engine\IO;

use Sendama\Engine\Core\Interfaces\SingletonInterface;

class GameObjectSerializer implements SingletonInterface
{
  protected static ?GameObjectSerializer $instance;

  private function __construct()
  {
    // This is a singleton class.
  }

  /**
   * @inheritDoc
   */
  public static function getInstance(): SingletonInterface
  {
    if (!self::$instance)
    {
      self::$instance = new GameObjectSerializer();
    }

    return self::$instance;
  }
}