<?php

namespace Sendama\Engine\Animation;

use Sendama\Engine\Animation\Interfaces\AnimationClipInterface;
use Sendama\Engine\Animation\Interfaces\AnimationControllerInterface;
use Sendama\Engine\Animation\Interfaces\AnimationControllerStateInterface;
use Sendama\Engine\Animation\States\InitialAnimationControllerState;
use Sendama\Engine\Animation\States\PausedClipState;
use Sendama\Engine\Animation\States\PlayingClipState;
use Sendama\Engine\Animation\States\StoppedClipState;
use Sendama\Engine\Animation\Strategies\PlayStrategy;
use Sendama\Engine\Core\Component;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Debug\Debug;

/**
 * The AnimationController class. This class is responsible for controlling the animation clips.
 *
 * @package Sendama\Engine\Animation
 */
class AnimationController extends Component implements AnimationControllerInterface
{
  /**
   * @var AnimationControllerStateInterface The state of the animation controller.
   */
  protected AnimationControllerStateInterface $state;
  /**
   * @var AnimationClipInterface[] The array of clips.
   */
  protected array $clips = [];
  /**
   * @var int The current clip index.
   */
  protected int $currentClipIndex = 0;
  /**
   * @var int|float The time.
   */
  protected int|float $time = 0;
  /**
   * @var float The speed.
   */
  protected float $speed = 1.0;
  /**
   * @var InitialAnimationControllerState The initial state.
   */
  public readonly InitialAnimationControllerState $initialState;
  /**
   * @var PausedClipState The paused state.
   */
  public readonly PausedClipState $pausedState;
  /**
   * @var PlayingClipState The playing state.
   */
  public readonly PlayingClipState $playingState;
  /**
   * @var StoppedClipState The stopped state.
   */
  public readonly StoppedClipState $stoppedState;
  /**
   * @var PlayStrategy The play strategy. The WrapMode determines which strategy to use.
   */
  public PlayStrategy $playStrategy;

  /**
   * AnimationController constructor.
   *
   * @param GameObject $gameObject The game object.
   */
  public function __construct(GameObject $gameObject)
  {
    parent::__construct($gameObject);

    $this->initialState = new InitialAnimationControllerState($this);
    $this->pausedState = new PausedClipState($this);
    $this->playingState = new PlayingClipState($this);
    $this->stoppedState = new StoppedClipState($this);

    $this->state = $this->initialState;
  }

  /**
   * @inheritDoc
   */
  public function setState(AnimationControllerStateInterface $state): void
  {
    $this->state = $state;
  }

  /**
   * @inheritDoc
   */
  public function getState(): AnimationControllerStateInterface
  {
    return $this->state;
  }

  /**
   * @inheritDoc
   */
  public function getSpeed(): float
  {
    return $this->speed;
  }

  /**
   * @inheritDoc
   */
  public function setSpeed(float $speed): void
  {
    $this->speed = $speed;
  }

  /**
   * @inheritDoc
   */
  public function getTime(): int|float
  {
    return $this->time;
  }

  /**
   * @inheritDoc
   */
  public function loadClip(string $name): void
  {
    foreach ($this->clips as $index => $clip)
    {
      if ($clip->getName() === $name)
      {
        $this->currentClipIndex = $index;
        break;
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function addClip(AnimationClipInterface $clip): void
  {
    $this->clips[] = $clip;
  }

  /**
   * @inheritDoc
   */
  public function removeClip(string $name): void
  {
    if (! isset($this->clips[$name]))
    {
      Debug::warn("Clip with name $name does not exist.");
      return;
    }

    unset($this->clips[$name]);
  }

  /**
   * @inheritDoc
   */
  public function playClip(): void
  {
    $this->state->playClip();
  }

  /**
   * @inheritDoc
   */
  public function pauseClip(): void
  {
    $this->state->pauseClip();
  }

  /**
   * @inheritDoc
   */
  public function resumeClip(): void
  {
    $this->state->resumeClip();
  }

  /**
   * @inheritDoc
   */
  public function stopClip(): void
  {
    $this->state->stopClip();
  }

  public function getTotalClips(): int
  {
    return count($this->clips);
  }

  /**
   * @inheritDoc
   */
  public function getCurrentClipIndex(): int
  {
    return $this->currentClipIndex;
  }

  /**
   * @inheritDoc
   */
  public function getCurrentClip(): ?AnimationClipInterface
  {
    return $this->clips[$this->currentClipIndex] ?? null;
  }

  /**
   * Set the play strategy. This determines how the
   *
   * @param PlayStrategy $playStrategy The play strategy.
   * @return void
   */
  public function setPlayStrategy(PlayStrategy $playStrategy): void
  {
    $this->playStrategy = $playStrategy;
  }
}