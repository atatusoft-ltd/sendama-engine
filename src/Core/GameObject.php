<?php

namespace Sendama\Engine\Core;

use InvalidArgumentException;
use Sendama\Engine\Core\Interfaces\ActivatableInterface;
use Sendama\Engine\Core\Interfaces\CanCompare;
use Sendama\Engine\Core\Interfaces\CanEquate;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\ComponentInterface;

/**
 * Class GameObject. This class represents a game object in the engine.
 *
 * @package Sendama\Engine\Core
 */
class GameObject implements CanCompare, CanResume, CanUpdate, CanStart, CanRender, ActivatableInterface
{
  /**
   * @var bool $active Whether the game object is active or not.
   */
  protected bool $active = true;
  /**
   * @var string $hash The hash of the game object.
   */
  protected string $hash = '';
  /**
   * @var ComponentInterface[] $components The components attached to the game object.
   */
  protected array $components = [];
  /**
   * @var Transform $transform The transform of the game object.
   */
  protected Transform $transform;
  /**
   * @var Renderer $renderer The renderer for the game object.
   */
  protected Renderer $renderer;

  /**
   * GameObject constructor.
   *
   * @param string $name The name of the game object.
   * @param string|null $tag The tag of the game object.
   */
  public function __construct(
    protected string  $name,
    protected ?string $tag = null,
    protected Vector2 $position = new Vector2(),
    protected Vector2 $rotation = new Vector2(),
    protected Vector2 $scale = new Vector2(),
    protected ?Sprite $sprite = null
  )
  {
    $this->hash = md5(__CLASS__) . '-' . uniqid($this->name, true);
    $this->transform = new Transform($this, $position, $scale, $rotation);
    $this->renderer = new Renderer($this, $sprite);

    $this->components[] = $this->transform;
    $this->components[] = $this->renderer;
  }

  public function __clone(): void
  {
    $this->hash = md5(__CLASS__) . '-' . uniqid($this->name, true);
  }

  /**
   * Returns the name of the game object.
   *
   * @return string The name of the game object.
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Returns the tag of the game object.
   *
   * @return string The tag of the game object.
   */
  public function getTag(): string
  {
    return $this->tag;
  }

  /**
   * Returns the transform of the game object.
   *
   * @return Transform The transform of the game object.
   */
  public function getTransform(): Transform
  {
    return $this->transform;
  }

  /**
   * Returns the renderer for the game object.
   *
   * @return Renderer The renderer for the game object.
   */
  public function getRenderer(): Renderer
  {
    return $this->renderer;
  }

  /**
   * @inheritDoc
   */
  public function compareTo(CanCompare $other): int
  {
    if (!$other instanceof GameObject) {
      throw new InvalidArgumentException('Cannot compare a game object with a non-game object.');
    }

    return strcmp($this->getHash(), $other->getHash());
  }

  /**
   * @inheritDoc
   */
  public function greaterThan(CanCompare $other): bool
  {
    return $this->compareTo($other) > 0;
  }

  /**
   * @inheritDoc
   */
  public function greaterThanOrEqual(CanCompare $other): bool
  {
    return $this->compareTo($other) >= 0;
  }

  /**
   * @inheritDoc
   */
  public function lessThan(CanCompare $other): bool
  {
    return $this->compareTo($other) < 0;
  }

  /**
   * @inheritDoc
   */
  public function lessThanOrEqual(CanCompare $other): bool
  {
    return $this->compareTo($other) <= 0;
  }

  /**
   * @inheritDoc
   */
  public function equals(CanEquate $equatable): bool
  {
    return $this->getHash() === $equatable->getHash();
  }

  /**
   * @inheritDoc
   */
  public function notEquals(CanEquate $equatable): bool
  {
    return !$this->equals($equatable);
  }

  /**
   * @inheritDoc
   */
  public function getHash(): string
  {
    return $this->hash;
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    if ($this->isActive() && $this->renderer->isActive() && $this->renderer->isEnabled())
    {
      $this->renderer->render();
    }
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    if ($this->isActive() && $this->renderer->isActive() && $this->renderer->isEnabled())
    {
      $this->renderer->renderAt($x, $y);
    }
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    if ($this->isActive() && $this->renderer->isActive() && $this->renderer->isEnabled())
    {
      $this->renderer->erase();
    }
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    if ($this->isActive() && $this->renderer->isActive() && $this->renderer->isEnabled())
    {
      $this->renderer->eraseAt($x, $y);
    }
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    if ($this->isActive())
    {
      foreach ($this->components as $component)
      {
        if ($component->isActive() && $component->isEnabled())
        {
          $component->resume();
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    if ($this->isActive())
    {
      foreach ($this->components as $component)
      {
        if ($component->isActive() && $component->isEnabled())
        {
          $component->suspend();
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    if ($this->isActive())
    {
      foreach ($this->components as $component)
      {
        if ($component->isActive() && $component->isEnabled())
        {
          $component->start();
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    if ($this->isActive())
    {
      foreach ($this->components as $component)
      {
        if ($component->isActive() && $component->isEnabled())
        {
          $component->stop();
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    if ($this->isActive())
    {
      foreach ($this->components as $component)
      {
        if ($component->isActive() && $component->isEnabled())
        {
          $component->update();
        }
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function activate(): void
  {
    $this->active = true;
    foreach ($this->components as $component)
    {
      $component->activate();
    }
  }

  /**
   * @inheritDoc
   */
  public function deactivate(): void
  {
    $this->active = false;
    foreach ($this->components as $component)
    {
      $component->activate();
    }
  }

  /**
   * @inheritDoc
   */
  public function isActive(): bool
  {
    return $this->active;
  }

  /**
   * Calls the method named $methodName on every component in this game object and its children.
   *
   * @param string $methodName The name of the method to call.
   * @param array<string, mixed> $args The arguments to pass to the method.
   * @return void
   */
  public function broadcast(string $methodName, array $args = []): void
  {
    foreach ($this->components as $component)
    {
      if (method_exists($component, $methodName))
      {
        $component->$methodName(...$args);
      }
    }
  }

  /**
   * Adds a component class of type $componentType to the game object.
   *
   * @param class-string<Component> $componentType
   *
   * @return Component The component that was added.
   */
  public function addComponent(string $componentType): Component
  {
    if (! class_exists($componentType) )
    {
      throw new InvalidArgumentException('The component type ' . $componentType . ' does not exist.');
    }

    $component = new $componentType($this);
    $this->components[] = $component;
    return $component;
  }

  /**
   * Returns the number of components attached to the game object.
   *
   * @return int The number of components attached to the game object.
   */
  public function getComponentCount(): int
  {
    return count($this->components);
  }

  /**
   * Gets the index of the component specified on the specified GameObject.
   *
   * @param Component $component The component to find.
   * @return int The index of the component, or -1 if the component is not found.
   */
  public function getComponentIndex(Component $component): int
  {
    foreach ($this->components as $index => $c)
    {
      if ($component->equals($c))
      {
        return $index;
      }
    }

    return -1;
  }

  /**
   * Gets a component of type $componentType from the game object.
   *
   * @param class-string $componentType
   * @return ComponentInterface|null The component of type $componentType.
   */
  public function getComponent(string $componentType): ?ComponentInterface
  {
    $component = null;

    foreach ($this->components as $component)
    {
      if ($component instanceof $componentType)
      {
        return $component;
      }
    }

    return $component;
  }

  /**
   * Returns the components attached to the game object.
   *
   * @return ComponentInterface[] The components attached to the game object.
   */
  public function getComponents(): array
  {
    return $this->components;
  }

  /**
   * Clones the original game object and returns the clone.
   *
   * @param GameObject $original
   * @param Vector2|null $position
   * @param Vector2|null $rotation
   * @param Vector2|null $scale
   * @param Transform|null $parent
   * @return GameObject
   */
  public static function instantiate(
    GameObject $original,
    ?Vector2 $position = null,
    ?Vector2 $rotation = null,
    ?Vector2 $scale = null,
    ?Transform $parent = null
  ): GameObject
  {
    $clone = clone $original;
    if ($position)
    {
      $clone->transform->setPosition($position);
    }

    if ($rotation)
    {
      $clone->transform->setRotation($rotation);
    }

    if ($scale)
    {
      $clone->transform->setScale($scale);
    }

    if ($parent)
    {
      $clone->transform->setParent($parent);
    }
    return $clone;
  }

  /**
   * Destroys the game object after the specified delay. This removes the game object from the scene.
   *
   * @param GameObject $gameObject The game object to destroy.
   * @param float $delay The delay before destroying the game object.
   * @return void
   */
  public static function destroy(GameObject $gameObject, float $delay = 0.0): void
  {
    // TODO: Implement destroy() method.
  }
}