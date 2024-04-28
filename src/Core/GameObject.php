<?php

namespace Sendama\Engine\Core;

use Sendama\Engine\Core\Interfaces\ActivatableInterface;
use Sendama\Engine\Core\Interfaces\CanCompare;
use Sendama\Engine\Core\Interfaces\CanEquate;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;

/**
 * Class GameObject
 * @package Sendama\Engine\Core
 */
class GameObject implements CanCompare, CanResume, CanUpdate, CanStart, CanRender, ActivatableInterface
{
  /**
   * @var bool
   */
  protected bool $active = false;
  protected string $hash = '';

  /**
   * GameObject constructor.
   *
   * @param string $name The name of the game object.
   * @param string|null $tag The tag of the game object.
   */
  public function __construct(
    protected string $name,
    protected ?string $tag = null,
  )
  {
    $this->hash = md5(__CLASS__) .  '-' . uniqid($this->name, true);
  }

  public function __clone(): void
  {
    $this->hash = md5(__CLASS__) .  '-' . uniqid($this->name, true);
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
   * @inheritDoc
   */
  public function compareTo(CanCompare $other): int
  {
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
    // TODO: Implement render() method.
  }

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
  public function erase(): void
  {
    // TODO: Implement erase() method.
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
  public function resume(): void
  {
    // TODO: Implement resume() method.
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
}