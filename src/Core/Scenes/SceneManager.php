<?php

namespace Sendama\Engine\Core\Scenes;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\Core\Scenes\Interfaces\SceneInterface;
use Sendama\Engine\Core\Scenes\Interfaces\SceneNodeInterface;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Events\Enumerations\SceneEventType;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Events\SceneEvent;
use Sendama\Engine\Exceptions\Scenes\SceneNotFoundException;

final class SceneManager implements SingletonInterface, CanStart, CanResume, CanUpdate, CanRender
{
  protected static ?SceneManager $instance = null;
  /**
   * @var ItemList<SceneInterface>
   */
  protected ItemList $scenes;
  /**
   * @var array<string, mixed>
   */
  protected array $settings = [];
  /**
   * @var SceneNodeInterface|null $activeScene
   */
  protected ?SceneNodeInterface $activeScene = null;
  /**
   * @var EventManager $eventManager
   */
  protected EventManager $eventManager;

  /**
   * @inheritDoc
   *
   * @return self
   */
  public static function getInstance(): self
  {
    if (!self::$instance)
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Constructs a SceneManager
   */
  private final function __construct()
  {
    $this->eventManager = EventManager::getInstance();
    $this->scenes = new ItemList(SceneInterface::class);
  }

  /**
   * Returns the currently active scene.
   *
   * @return SceneInterface|null
   */
  public function getActiveScene(): ?SceneInterface
  {
    return $this->activeScene?->getScene();
  }

  /**
   * Returns the previous scene.
   *
   * @return SceneInterface|null The previous scene.
   */
  public function getPreviousScene(): ?SceneInterface
  {
    return $this->activeScene?->getPreviousScene();
  }

  /**
   * @param SceneInterface $scene
   * @param mixed|null $data
   * @return $this
   */
  public function addScene(SceneInterface $scene, mixed $data = null): self
  {
    $this->scenes->add($scene);

    return $this;
  }

  /**
   * @return $this
   */
  public function removeScene(SceneInterface $scene): self
  {
    $this->scenes->remove($scene);

    return $this;
  }

  /**
   * Loads the scene with the given index.
   *
   * @param int|string $index The index of the scene to load. If a string is provided, the scene with the name will be
   * loaded. If an integer is provided, the scene at the index will be loaded.
   * @return $this The SceneManager instance.
   *
   * @throws SceneNotFoundException
   */
  public function loadScene(int|string $index): self
  {
    Debug::info("Loading scene: $index");
    $this->eventManager->dispatchEvent(new SceneEvent(SceneEventType::LOAD_START));

    $sceneToBeLoaded = null;

    $scenes = $this->scenes->toArray();
    /**
     * @var SceneInterface $scene
     */
    foreach ($scenes as $i => $scene)
    {
      if (is_int($index) && $i === (int)$index)
      {
        $sceneToBeLoaded = $scene;
        break;
      }

      if (is_string($index) && $scene->getName() === $index)
      {
        $sceneToBeLoaded = $scene;
        break;
      }
    }

    if (!$sceneToBeLoaded)
    {
      throw new SceneNotFoundException($index);
    }

    $this->stop();
    $this->activeScene = new SceneNode(
      $sceneToBeLoaded->loadSceneSettings($this->settings),
      $this->activeScene?->getScene()
    );

    $this->eventManager->dispatchEvent(new SceneEvent(SceneEventType::LOAD_END));

    $this->start();
    return $this;
  }

  /**
   * Loads the previous scene.
   *
   * @return $this The SceneManager instance.
   * @throws SceneNotFoundException If the previous scene is not found.
   */
  public function loadPreviousScene(): self
  {
    Debug::info("Loading previous scene");

    if ($this->getPreviousScene())
    {
      return $this->loadScene($this->getPreviousScene()->getName());
    }

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->activeScene?->getScene()->render();
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    $this->activeScene?->getScene()->renderAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->activeScene?->getScene()->erase();
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    $this->activeScene?->getScene()->eraseAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    $this->activeScene?->getScene()->resume();
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    $this->activeScene?->getScene()->suspend();
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    $this->activeScene?->getScene()->start();
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    $this->activeScene?->getScene()->stop();
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    if ($this->activeScene)
    {
      $this->activeScene->getScene()->update();
      $this->eventManager->dispatchEvent(
        new SceneEvent(SceneEventType::UPDATE, $this->activeScene->getScene())
      );
    }
  }

  /**
   * Loads the settings for the SceneManager.
   *
   * @param array<string, mixed> $settings
   */
  public function loadSettings(?array $settings = null): void
  {
    if ($settings)
    {
      $this->settings = $settings;
    }
  }

  /**
   * Returns the settings for the SceneManager.
   *
   * @param string|null $key
   * @return mixed
   */
  public function getSettings(?string $key = null): mixed
  {
    return $this->settings[$key] ?? $this->settings;
  }
}