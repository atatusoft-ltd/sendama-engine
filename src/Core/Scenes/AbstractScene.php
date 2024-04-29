<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Debug\Debug;

/**
 * The abstract scene class.
 */
class AbstractScene implements SceneInterface
{
  /**
   * @var array<string, mixed> $settings
   */
  protected array $settings = [];

  /**
   * @var array<GameObject> $rootGameObjects
   */
  public array $rootGameObjects = [];

  /**
   * Constructs a scene.
   *
   * @param string $name The name of the scene.
   */
  public function __construct(
    protected string $name
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @inheritDoc
   */
  public final function renderAt(?int $x = null, ?int $y = null): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public final function eraseAt(?int $x = null, ?int $y = null): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public final function loadSceneSettings(?array $settings = null): self
  {
    foreach ($settings as $key => $value)
    {
      $this->settings[$key] = $value;
    }

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    Debug::log("Scene started: " . $this->name);
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      $rootGameObject->start();
    }
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    Debug::log("Scene stopped: " . $this->name);
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      $rootGameObject->stop();
    }
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      if ($rootGameObject->isActive())
      {
        $rootGameObject->update();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      if ($rootGameObject->isActive())
      {
        $rootGameObject->render();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      if ($rootGameObject->isActive())
      {
        $rootGameObject->erase();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      if ($rootGameObject->isActive())
      {
        $rootGameObject->suspend();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    foreach ($this->rootGameObjects as $rootGameObject)
    {
      if ($rootGameObject->isActive())
      {
        $rootGameObject->resume();
      }
    }
  }

  /**
   * @return object[] The list of root game objects in the scene.
   */
  public function getRootGameObjects(): array
  {
    return $this->rootGameObjects;
  }
}