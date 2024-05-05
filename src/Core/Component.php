<?php

namespace Sendama\Engine\Core;

use InvalidArgumentException;
use Sendama\Engine\Core\Interfaces\CanCompare;
use Sendama\Engine\Core\Interfaces\CanEquate;
use Sendama\Engine\Core\Interfaces\ComponentInterface;

/**
 * Represents a component. This class is the base class for all components in the engine.
 */
abstract class Component implements ComponentInterface
{
  /**
   * @var bool $active Whether the component is active or not.
   */
  protected bool $active = true;
  /**
   * @var bool $enabled Whether the component is enabled or not.
   */
  protected bool $enabled = true;

  /**
   * @var string
   */
  protected string $hash;

  public function __construct(protected GameObject $gameObject)
  {
    $this->hash = md5(__CLASS__) .  '-' . uniqid($this->gameObject->getName(), true);

    $this->awake();
  }

  /**
   * @inheritDoc
   */
  public final function getGameObject(): GameObject
  {
    return $this->gameObject;
  }

  /**
   * @inheritDoc
   */
  public final function getTransform(): Transform
  {
    return $this->gameObject->getTransform();
  }

  /**
   * Activates the component.
   *
   * @inheritDoc
   */
  public final function activate(): void
  {
    $this->active = true;
    $this->onActivate();
  }

  /**
   * Called when the component is activated.
   *
   * @return void
   */
  public function onActivate(): void
  {
    // Do nothing
  }

  /**
   * Deactivates the component.
   *
   * @inheritDoc
   */
  public final function deactivate(): void
  {
    $this->active = false;
    $this->onDeactivate();
  }

  /**
   * Called when the component is deactivated.
   *
   * @return void
   */
  public function onDeactivate(): void
  {
    // Do nothing
  }

  /**
   * Determines whether the component is active or not.
   *
   * @inheritDoc
   */
  public function isActive(): bool
  {
    return $this->active;
  }

  /**
   * Enables the component.
   *
   * @inheritDoc
   */
  public final function enable(): void
  {
    $this->enabled = true;
    $this->onEnable();
  }

  /**
   * Called when the component is enabled.
   *
   * @return void
   */
  public function onEnable(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public final function disable(): void
  {
    $this->enabled = false;
    $this->onDisable();
  }

  /**
   * Called when the component is disabled.
   *
   * @return void
   */
  public function onDisable(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public final function isEnabled(): bool
  {
    return $this->enabled;
  }

  /**
   * @inheritDoc
   */
  public function compareTo(CanCompare $other): int
  {
    if (! $other instanceof Component)
    {
      throw new InvalidArgumentException('Cannot compare a component with a non-component.');
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
    return $this->getHash() !== $equatable->getHash();
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
  public final function resume(): void
  {
    $this->onResume();
  }

  /**
   * Called when the component is resumed.
   *
   * @return void
   */
  public function onResume(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public final function suspend(): void
  {
    $this->onSuspend();
  }

  /**
   * Called when the component is suspended.
   *
   * @return void
   */
  public function onSuspend(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public final function start(): void
  {
    $this->activate();
    $this->enable();
    $this->onStart();
  }

  /**
   * Called when the component is started.
   *
   * @return void
   */
  public function onStart(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public final function stop(): void
  {
    $this->deactivate();
    $this->disable();
    $this->onStop();
  }

  /**
   * Called when the component is stopped.
   *
   * @return void
   */
  public function onStop(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public final function update(): void
  {
    if ($this->isActive() && $this->isEnabled())
    {
      $this->onUpdate();
    }
  }

  /**
   * Called when the component is updated.
   *
   * @return void
   */
  public function onUpdate(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    // Do nothing
  }

  /**
   * @inheritDoc
   */
  public function broadcast(string $methodName, array $args = []): void
  {
    $this->gameObject->broadcast($methodName, $args);
  }

  /**
   * @inheritDoc
   */
  public function hasTag(string $tag): bool
  {
    return $this->gameObject->getTag() === $tag;
  }

  /**
   * Serializes the component.
   */
  public function __serialize(): array
  {
    return get_object_vars($this);
  }

  /**
   * Deserializes the component.
   */
  public function __unserialize(array $data): void
  {
    foreach ($data as $key => $value)
    {
      $this->{$key} = $value;
    }
  }
}