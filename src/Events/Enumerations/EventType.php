<?php

namespace Sendama\Engine\Events\Enumerations;

use Sendama\Engine\Events\AchievementEvent;
use Sendama\Engine\Events\BattleEvent;
use Sendama\Engine\Events\DialogEvent;
use Sendama\Engine\Events\GameEvent;
use Sendama\Engine\Events\GameplayEvent;
use Sendama\Engine\Events\KeyboardEvent;
use Sendama\Engine\Events\MapEvent;
use Sendama\Engine\Events\MenuEvent;
use Sendama\Engine\Events\ModalEvent;
use Sendama\Engine\Events\MovementEvent;
use Sendama\Engine\Events\NotificationEvent;
use Sendama\Engine\Events\SceneEvent;
use Sendama\Engine\Events\TimeEvent;

/**
 * EventTypes is an enumeration of all event types.
 */
enum EventType: string
{
  case ACHIEVEMENT = AchievementEvent::class;
  case GAME = GameEvent::class;
  case KEYBOARD = KeyboardEvent::class;
  case SCENE = SceneEvent::class;
  case TIME = TimeEvent::class;
  case BATTLE = BattleEvent::class;
  case DIALOG = DialogEvent::class;
  case MOVEMENT = MovementEvent::class;
  case MAP = MapEvent::class;
  case MODAL = ModalEvent::class;
  case MENU = MenuEvent::class;
  case GAME_PLAY = GameplayEvent::class;
  case NOTIFICATION = NotificationEvent::class;
}
