<?php

namespace Sendama\Engine\UI;

use Sendama\Engine\Core\Scenes\Interfaces\SceneInterface;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\UI\Interfaces\UIElementInterface;

/**
 * The abstract UI element class.
 *
 * @package Sendama\Engine\UI
 */
abstract class UIElement implements UIElementInterface
{
  /**
   * Whether the UI element is active.
   *
   * @var bool
   */
  protected bool $active = true;

  /**
   * Constructs a UI element.
   *
   * @param SceneInterface $scene The scene.
   * @param string $name The name of the UI element.
   * @param Vector2 $position The position of the UI element.
   * @param Vector2 $size The size of the UI element.
   */
  public function __construct(
    protected SceneInterface $scene,
    protected string $name,
    protected Vector2 $position = new Vector2(0, 0),
    protected Vector2 $size = new Vector2(0, 0),
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function activate(): void
  {
    $this->active = true;
  }

  /**
   * @inheritDoc
   */
  public function deactivate(): void
  {
    $this->active = false;
  }

  /**
   * @inheritDoc
   */
  public function isActive(): bool
  {
    return $this->active;
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    $this->render();
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    $this->erase();
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    $this->erase();
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
  public function setName(string $name): void
  {
    $this->name = $name;
  }
}