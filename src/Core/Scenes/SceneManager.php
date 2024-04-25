<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\Interfaces\SingletonInterface;

class SceneManager implements SingletonInterface
{
  protected static ?SceneManager $instance = null;

  protected array $settings = [];

  public static function getInstance(): self
  {
    // TODO: Implement getInstance() method.
    if (!self::$instance)
    {
      self::$instance = new self();
    }

    return self::$instance;
  }
}