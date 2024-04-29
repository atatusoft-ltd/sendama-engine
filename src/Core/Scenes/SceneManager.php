<?php

namespace Sendama\Engine\Core\Scenes;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
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
   * @var SceneInterface|null $activeScene
   */
  protected ?SceneInterface $activeScene = null;
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
    return $this->activeScene;
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
   * @param int|string $index
   * @return $this
   *
   * @throws SceneNotFoundException
   */
  public function loadScene(int|string $index): self
  {
    Debug::info("Loading scene: $index");
    $this->eventManager->dispatchEvent(new SceneEvent(SceneEventType::LOAD_START));

    $sceneToBeLoaded = null;

    foreach ($this->scenes as $i => $scene)
    {
      if ($scene->getName() === $index || $i === $index)
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
    $this->activeScene = $sceneToBeLoaded->loadSceneSettings($this->settings);

    $this->eventManager->dispatchEvent(new SceneEvent(SceneEventType::LOAD_END));

    $this->start();
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->activeScene?->render();
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    $this->activeScene?->renderAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->activeScene?->erase();
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    $this->activeScene?->eraseAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    $this->activeScene?->resume();
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    $this->activeScene?->suspend();
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    $this->activeScene?->start();
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    $this->activeScene?->stop();
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    if ($this->activeScene)
    {
      $this->activeScene->update();
      $this->eventManager->dispatchEvent(
        new SceneEvent(SceneEventType::UPDATE, $this->activeScene)
      );
    }
  }
}