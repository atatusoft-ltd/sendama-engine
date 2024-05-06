<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Rendering\Camera;
use Sendama\Engine\Core\Rendering\Interfaces\CameraInterface;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Physics;
use Serializable;

/**
 * The abstract scene class.
 *
 * @package Sendama\Engine\Core\Scenes
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
  /**
   * @var Physics
   */
  protected Physics $physics;

  /**
   * @var array<array<int>> $worldsSpace
   */
  protected array $worldsSpace = [];

  /**
   * @var CameraInterface $camera
   */
  protected CameraInterface $camera;

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
    $this->camera = new Camera($this);
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

    if (isset($this->settings['screen_width']) && isset($this->settings['screen_height']))
    {
      $oldViewport = $this->camera->getViewport();
      $this->camera->setViewport(
        new Rect(
          $this->camera->getOffset(),
          new Vector2(
            $this->settings['screen_width'] ?? $oldViewport->getWidth(),
            $this->settings['screen_height'] ?? $oldViewport->getHeight()
          )
        )
      );
    }

    return $this;
  }

  /**
   * @inheritDoc
   */
  public final function start(): void
  {
    Debug::log("Scene started: " . $this->name);
    $this->createWordsSpace();

    foreach ($this->rootGameObjects as $gameObject)
    {
      $gameObject->start();
    }
  }

  /**
   * @inheritDoc
   */
  public final function stop(): void
  {
    Debug::log("Scene stopped: " . $this->name);
    foreach ($this->rootGameObjects as $gameObject)
    {
      $gameObject->stop();
    }
  }

  /**
   * @inheritDoc
   */
  public final function update(): void
  {
    $this->physics->simulate();

    foreach ($this->rootGameObjects as $gameObject)
    {
      if ($gameObject->isActive())
      {
        $gameObject->update();
      }
    }

    // Update the camera
    $this->camera->update();
  }

  /**
   * @inheritDoc
   */
  public final function render(): void
  {
    foreach ($this->rootGameObjects as $gameObject)
    {
      if ($gameObject->isActive())
      {
        $gameObject->render();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public final function erase(): void
  {
    foreach ($this->rootGameObjects as $gameObject)
    {
      if ($gameObject->isActive())
      {
        $gameObject->erase();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public final function suspend(): void
  {
    foreach ($this->rootGameObjects as $gameObject)
    {
      if ($gameObject->isActive())
      {
        $gameObject->suspend();
      }
    }
  }

  /**
   * @inheritDoc
   */
  public final function resume(): void
  {
    foreach ($this->rootGameObjects as $gameObject)
    {
      if ($gameObject->isActive())
      {
        $gameObject->resume();
      }
    }
  }

  /**
   * @return GameObject[] The list of root game objects in the scene.
   */
  public final function getRootGameObjects(): array
  {
    return $this->rootGameObjects;
  }

  /**
   * @inheritDoc
   */
  public function serialize(): string
  {
    return json_encode([
      'name' => $this->name,
      'settings' => $this->settings,
      'rootGameObjects' => $this->rootGameObjects
    ]);
  }

  /**
   * @inheritDoc
   */
  public function unserialize(string $data): void
  {
    $data = json_decode($data, true);

    $this->name = $data['name'];
    $this->settings = $data['settings'];
    $this->rootGameObjects = $data['rootGameObjects'];
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

  /**
   * Creates the words space.
   */
  private function createWordsSpace(): void
  {
    $width = $this->settings['screen_width'];
    $height = $this->settings['screen_height'];

    for ($y = 0; $y < $height; $y++)
    {
      $this->worldsSpace[$y] = array_fill(0, $width, 0);
    }
  }

  /**
   * Adds a game object to the scene.
   *
   * @param GameObject $gameObject The game object to add.
   */
  public function add(GameObject $gameObject): void
  {
    $this->rootGameObjects[] = $gameObject;
  }

  /**
   * Removes a game object from the scene.
   *
   * @param GameObject $gameObject The game object to remove.
   */
  public function remove(GameObject $gameObject): void
  {
    $this->rootGameObjects = array_filter($this->rootGameObjects, fn($item) => $item !== $gameObject, $this->rootGameObjects);
  }

  /**
   * Returns the camera.
   *
   * @return CameraInterface The camera.
   */
  public function getCamera(): CameraInterface
  {
    return $this->camera;
  }
}