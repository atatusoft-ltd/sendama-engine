<?php

namespace Sendama\Examples\Collector\Scripts\Game;

use Sendama\Engine\Core\Behaviours\Attributes\SerializeField;
use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObservableInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;
use Sendama\Examples\Collector\Scripts\Game\Events\ScoreUpdateEvent;

/**
 * Class LevelManager is responsible for managing the game level.
 *
 * @package Sendama\Examples\Collector\Scripts\Game
 */
class LevelManager extends Behaviour implements ObservableInterface
{
  /**
   * @var Vector2|array
   */
  public Vector2|array $playerStartingPosition = [0, 0];
  /**
   * @var int $score The current score.
   */
  #[SerializeField]
  protected int $score = 0;
  /**
   * @var array<ObserverInterface|StaticObserverInterface|string> $observers The observers.
   */
  protected array $observers = [];
  /**
   * @var EventManager $eventManager The event manager.
   */
  protected EventManager $eventManager;

  public function onStart(): void
  {
    $this->eventManager = EventManager::getInstance();

    if (is_array($this->playerStartingPosition))
    {
      $this->playerStartingPosition = Vector2::fromArray($this->playerStartingPosition);
    }
  }

  /**
   * @inheritDoc
   */
  public function onUpdate(): void
  {
    if (Input::isKeyDown(KeyCode::ESCAPE))
    {
      pauseGame();
    }

    if (Input::isAnyKeyPressed([KeyCode::Q, KeyCode::q]))
    {
      quitGame();
    }
  }

  /**
   * Sets the player's starting position.
   *
   * @param Vector2|array $position The player's starting position.
   */
  public function setPlayerStartingPosition(Vector2|array $position): void
  {
    $this->playerStartingPosition = match (true)
    {
      is_array($position) => Vector2::fromArray($position),
      default => $position
    };
  }

  /**
   * Increments the score by the given amount.
   *
   * @param int $increment The amount to increment the score by.
   */
  public function incrementScore(int $increment = 1): void
  {
    $this->score += $increment;
    $this->notify(new ScoreUpdateEvent($this->score));
  }

  /**
   * Returns the current score.
   *
   * @return int The current score.
   */
  public function getScore(): int
  {
    return $this->score;
  }

  public function addObservers(string|StaticObserverInterface|ObserverInterface ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers[] = $observer;
    }
  }

  public function removeObservers(string|StaticObserverInterface|ObserverInterface|null ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $index = array_search($observer, $this->observers, true);

      if ($index !== false)
      {
        unset($this->observers[$index]);
      }
    }
  }

  public function notify(EventInterface $event): void
  {
    foreach ($this->observers as $observer)
    {
      $observer->onNotify($this, $event);
    }
  }
}