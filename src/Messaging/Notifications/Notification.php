<?php

namespace Sendama\Engine\Messaging\Notifications;

use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Events\Enumerations\NotificationEventType;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Events\NotificationEvent;
use Sendama\Engine\Messaging\Notifications\Enumerations\NotificationChannel;
use Sendama\Engine\Messaging\Notifications\Enumerations\NotificationDuration;
use Sendama\Engine\Messaging\Notifications\Interfaces\NotificationInterface;
use Sendama\Engine\UI\Windows\BorderPack;
use Sendama\Engine\UI\Windows\Enumerations\HorizontalAlignment;
use Sendama\Engine\UI\Windows\Enumerations\VerticalAlignment;
use Sendama\Engine\UI\Windows\Interfaces\BorderPackInterface;
use Sendama\Engine\UI\Windows\Window;
use Sendama\Engine\UI\Windows\WindowAlignment;
use Sendama\Engine\UI\Windows\WindowPadding;

class Notification implements NotificationInterface
{
  /**
   * The notification width.
   */
  public const int WIDTH = 40;
  /**
   * The notification height.
   */
  public const int HEIGHT = 5;
  /**
   * @var Window The notification window.
   */
  protected Window $window;
  /**
   * @var Vector2 The notification position.
   */
  protected Vector2 $position;
  /**
   * @var WindowAlignment The alignment of the notification content.
   */
  protected WindowAlignment $contentAlignment;
  /**
   * @var WindowPadding The padding of the notification content.
   */
  protected WindowPadding $contentPadding;
  /**
   * @var array The notification content.
   */
  protected array $content = [];
  /**
   * @var bool Whether the notification is open.
   */
  protected bool $isOpen = false;
  /**
   * @var bool Whether the notification is dismissing.
   */
  protected bool $isDismissing = false;
  /**
   * @var EventManager $eventManager The event manager.
   */
  protected EventManager $eventManager;
  /**
   * @var mixed $sceneEventHandler The scene event handler.
   */
  protected mixed $sceneEventHandler = null;
  /**
   * @var mixed $mapEventHandler The map event handler.
   */
  protected string $id = '';

  /**
   * Notification constructor.
   *
   * @param NotificationChannel $channel The notification channel.
   * @param string $contentTitle The notification title.
   * @param string $contentText The notification text.
   * @param NotificationDuration|float $duration The notification duration.
   * @param BorderPackInterface $borderPack The notification border pack.
   */
  public function __construct(
    protected NotificationChannel $channel,
    protected string $contentTitle = '',
    protected string $contentText = '',
    protected NotificationDuration|float $duration = NotificationDuration::MEDIUM,
    protected BorderPackInterface $borderPack = new BorderPack(''),
  )
  {
    $this->id = uniqid('notification_');
    $this->eventManager = EventManager::getInstance();

    $leftMargin = DEFAULT_SCREEN_WIDTH - self::WIDTH - 16;
    $topMargin = 0;

    $this->position = new Vector2($leftMargin, $topMargin);
    $this->contentPadding =
      new WindowPadding(0, 1, 0, 1);
    $this->contentAlignment =
      new WindowAlignment(HorizontalAlignment::LEFT, VerticalAlignment::MIDDLE);

    $this->window = new Window(
      $this->channel->value,
      '',
      $this->position,
      self::WIDTH,
      self::HEIGHT,
      $this->borderPack,
      $this->contentAlignment,
      $this->contentPadding
    );
  }

  /**
   * Returns the position of the notification window.
   *
   * @return Vector2 Returns the notification position.
   */
  public function getPosition(): Vector2
  {
    return $this->position;
  }

  /**
   * Updates the notification position.
   *
   * @param Vector2 $position The notification position.
   * @return $this Returns the notification.
   */
  public function setPosition(Vector2 $position): static
  {
    $this->position = $position;
    $this->window->setPosition($position);
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function open(?Vector2 $position = null): static
  {
    $this->isOpen = true;
    if ($position) {
      $this->window->setPosition($position);
    }
    $this->buildWindowContent();

    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::OPEN));
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function dismiss(): static
  {
    $this->erase();
    $this->isOpen = false;

    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::DISMISS));
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->renderAt();
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    if ($this->isOpen) {
      $this->window->renderAt($x, $y);
    }
    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::RENDER));
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->eraseAt();
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    if ($this->isOpen) {
      $this->window->eraseAt($x, $y);
    }
    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::ERASE));
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    $this->buildWindowContent();

    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::RESUME));
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    $this->erase();

    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::SUSPEND));
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    $this->eventManager->dispatchEvent(new NotificationEvent(NotificationEventType::UPDATE));
  }

  /**
   * @inheritDoc
   */
  public function getChannel(): NotificationChannel
  {
    return $this->channel;
  }

  /**
   * @inheritDoc
   */
  public function setChannel(NotificationChannel $channel): static
  {
    $this->channel = $channel;

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function getContentTitle(): string
  {
    return $this->contentTitle;
  }

  /**
   * @inheritDoc
   */
  public function setContentTitle(string $contentTitle): static
  {
    $this->contentTitle = $contentTitle;
    $this->buildWindowContent();

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function getContentText(): string
  {
    return $this->contentText;
  }

  /**
   * @inheritDoc
   */
  public function setContentText(string $contentText): static
  {
    $this->contentText = $contentText;

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function getDuration(): float
  {
    return $this->duration instanceof NotificationDuration
      ? $this->duration->toFloat()
      : $this->duration;
  }

  /**
   * @inheritDoc
   */
  public function setDuration(NotificationDuration|float $duration): static
  {
    $this->duration = $duration;

    return $this;
  }

  /**
   * Builds the notification window content.
   *
   * @return void
   */
  private function buildWindowContent(): void
  {
    $this->content = [
      $this->getContentTitle(),
      $this->getContentText()
    ];
    $this->window->setContent($this->content);
  }
}