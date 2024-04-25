<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\Interfaces\SceneInterface;

class AbstractScene implements SceneInterface
{
  /**
   * @var array<string, mixed> $settings
   */
  protected array $settings = [];
  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement renderAt() method.
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  /**
   * @inheritDoc
   */
  public function loadSceneSettings(?array $settings = null): self
  {
    // TODO: Implement loadSceneSettings() method.

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    // TODO: Implement start() method.
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    // TODO: Implement stop() method.
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    // TODO: Implement update() method.
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    // TODO: Implement render() method.
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    // TODO: Implement suspend() method.
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    // TODO: Implement resume() method.
  }
}