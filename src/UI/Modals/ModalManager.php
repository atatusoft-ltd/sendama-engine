<?php

namespace Sendama\Engine\UI\Modals;

use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\SingletonInterface;

/**
 * The Modal manager class is responsible for creating, managing and disposing of modals.
 *
 * @package Sendama\Engine\UI
 */
class ModalManager implements SingletonInterface, CanStart, CanUpdate, CanRender, CanResume
{
  protected static ?ModalManager $instance = null;

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

  public function erase(): void
  {
    // TODO: Implement erase() method.
  }

  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    // TODO: Implement eraseAt() method.
  }

  public function resume(): void
  {
    // TODO: Implement resume() method.
  }

  public function suspend(): void
  {
    // TODO: Implement suspend() method.
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

  /**
   * @inheritDoc
   *
   * @return self
   */
  public static function getInstance(): self
  {
    // TODO: Implement getInstance() method.
    if (!self::$instance)
    {
      self::$instance = new self();
    }

    return self::$instance;
  }
}