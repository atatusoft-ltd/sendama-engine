<?php

namespace Sendama\Engine\States;

use Sendama\Engine\Debug\Debug;
use Sendama\Engine\IO\Console\Console;
use Sendama\Engine\IO\Input;
use Sendama\Engine\UI\Menus\Menu;

class PausedState extends GameState
{
  /**
   * @var Menu|null $menu The pause menu
   */
  protected ?Menu $menu = null;

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    if (Input::isKeyDown($this->context->getSettings('pause_key')))
    {
      $this->resume();
    }

    $this->menu?->update();
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    if ($this->menu)
    {
      // Display the pause menu
      $this->menu->render();
    }
    else
    {
      $this->renderDefaultPauseText();
    }
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    Console::clear();
    $this->context->setState($this->context->getState('scene'));
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    // Do nothing
  }

  private function renderDefaultPauseText(): void
  {
    $promptText = 'PAUSED';
    $leftMargin = ($this->context->getSettings('screen_width') / 2) - (strlen($promptText) / 2);
    $topMargin = ($this->context->getSettings('screen_height') / 2) - 1;
    Console::writeLine($promptText, $leftMargin, $topMargin);
  }
}