<?php

namespace Sendama\Examples\Collector\Scripts\Game;

use Sendama\Engine\Core\Behaviours\Attributes\SerializeField;
use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;

/**
 * Class LevelManager is responsible for managing the game level.
 *
 * @package Sendama\Examples\Collector\Scripts\Game
 */
class LevelManager extends Behaviour
{
  /**
   * @var Vector2|array
   */
  public Vector2|array $playerStartingPosition = [0, 0];
  #[SerializeField]
  protected int $score = 0;

  public function onStart(): void
  {
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
}