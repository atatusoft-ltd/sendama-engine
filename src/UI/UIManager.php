<?php

namespace Sendama\Engine\UI;

use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SingletonInterface;

final class UIManager implements SingletonInterface, CanStart, CanUpdate, CanRender
{
  protected static ?UIManager $instance = null;

  /**
   * Constructs a UIManager
   */
  private final function __construct()
  {
    // This is a singleton class.
  }

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
   * @inheritDoc
   */
  public function render(): void
  {
    $this->renderAt(0, 0);
  }

  public function renderAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement renderAt() method.
  }

  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  public function start(): void
  {
    // TODO: Implement start() method.
  }

  public function stop(): void
  {
    // TODO: Implement stop() method.
  }

  public function update(): void
  {
    // TODO: Implement update() method.
  }
}