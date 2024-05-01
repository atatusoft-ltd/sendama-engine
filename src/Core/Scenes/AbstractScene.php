<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Physics;
use Serializable;

/**
 * The abstract scene class.
 */
class AbstractScene implements SceneInterface, Serializable
{
  /**
   * @var array<string, mixed> $settings
   */
  protected array $settings = [];

  /**
   * @var array<GameObject> $rootGameObjects
   */
  public array $rootGameObjects = [];
  protected Physics $physics;

  /**
   * Constructs a scene.
   *
   * @param string $name The name of the scene.
   */
  public function __construct(
    protected string $name
  )
  {
    $this->physics = Physics::getInstance();
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
    $this->physics->simulate();

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

  public function serialize(): void
  {
    // TODO: Implement serialize() method.
  }

  public function unserialize(string $data): void
  {
    // TODO: Implement unserialize() method.
  }

  public function __serialize(): array
  {
    return [
      'name' => $this->name,
      'settings' => $this->settings,
      'rootGameObjects' => $this->rootGameObjects
    ];
  }

  public function __unserialize(array $data): void
  {
    $this->name = $data['name'];
    $this->settings = $data['settings'];
    $this->rootGameObjects = $data['rootGameObjects'];
  }
}