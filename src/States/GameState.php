<?php

namespace Sendama\Engine\States;

use Sendama\Engine\Core\Scenes\SceneManager;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Game;
use Sendama\Engine\Interfaces\GameStateInterface;
use Sendama\Engine\Messaging\Notifications\NotificationsManager;
use Sendama\Engine\UI\Modals\ModalManager;
use Sendama\Engine\UI\UIManager;

/**
 * Class GameState. Represents a state of the game.
 */
abstract class GameState implements GameStateInterface
{
  public final function __construct(
    protected Game $context,
    protected SceneManager $sceneManager,
    protected EventManager $eventManager,
    protected ModalManager $modalManager,
    protected NotificationsManager $notificationsManager,
    protected UIManager $UIManager,
  )
  {
  }
}