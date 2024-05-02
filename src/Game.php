<?php

namespace Sendama\Engine;

use Assegai\Collections\ItemList;
use Dotenv\Dotenv;
use Error;
use Exception;
use Sendama\Engine\Core\Enumerations\ChronoUnit;
use Sendama\Engine\Core\Interfaces\SceneInterface;
use Sendama\Engine\Core\Scenes\SceneManager;
use Sendama\Engine\Core\Time;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Debug\Enumerations\LogLevel;
use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Enumerations\GameEventType;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Events\GameEvent;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObservableInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;
use Sendama\Engine\Exceptions\InitializationException;
use Sendama\Engine\Exceptions\Scenes\SceneNotFoundException;
use Sendama\Engine\IO\Console\Console;
use Sendama\Engine\IO\InputManager;
use Sendama\Engine\Messaging\Notifications\NotificationsManager;
use Sendama\Engine\UI\ModalManager;
use Sendama\Engine\UI\UIManager;
use Sendama\Engine\Util\Path;
use Throwable;

/**
 * The main Game engine class.
 *
 * @package Sendama\Engine;
 */
class Game implements ObservableInterface
{
  /**
   * @var array<string|Throwable|Exception|Error>
   */
  private array $errors = [];
  /**
   * @var array<string, mixed>
   */
  private array $settings = [];
  /**
   * @var ItemList<ObserverInterface>
   */
  private ItemList $observers;
  /**
   * @var ItemList<StaticObserverInterface>
   */
  private ItemList $staticObservers;
  /**
   * @var int The number of frames that have been rendered.
   */
  private int $frameCount = 0;
  /**
   * @var int The frame rate of the game.
   */
  private int $frameRate = 0;

  /* == Managers == */
  /**
   * @var SceneManager $sceneManager
   */
  private SceneManager $sceneManager;
  /**
   * @var EventManager $eventManager
   */
  private EventManager $eventManager;
  /**
   * @var ModalManager $modalManager
   */
  private ModalManager $modalManager;
  /**
   * @var NotificationsManager $notificationsManager
   */
  private NotificationsManager $notificationsManager;
  /**
   * @var UIManager $uiManager
   */
  private UIManager $uiManager;

  /* Sentinel properties */
  /**
   * @var bool Determines if the game engine is running.
   */
  private bool $isRunning = false;
  /**
   * @var bool Determines if a modal is showing or not.
   */
  private bool $isShowingModal = false;

  /**
   * Game constructor.
   *
   * @param string $name The name of the game.
   * @param int $screenWidth The width of the game screen.
   * @param int $screenHeight The height of the game screen.
   */
  public function __construct(
    private readonly string $name,
    private readonly int $screenWidth = DEFAULT_SCREEN_WIDTH,
    private readonly int $screenHeight = DEFAULT_SCREEN_HEIGHT,
  )
  {
    // Load environment variables
    if (file_exists(getcwd() . '/.env'))
    {
      $dotenv = Dotenv::createImmutable(getcwd());
      $dotenv->load();
    }

    // Initialize console
    Console::init();

    // Initialize managers
    $this->sceneManager         = SceneManager::getInstance();
    $this->eventManager         = EventManager::getInstance();
    $this->modalManager         = ModalManager::getInstance();
    $this->notificationsManager = NotificationsManager::getInstance();
    $this->uiManager            = UIManager::getInstance();

    // Initialize observers
    $this->observers = new ItemList(ObserverInterface::class);
    $this->staticObservers = new ItemList(StaticObserverInterface::class);

    // Load default settings
    $this->initializeSettings();

    // Handle exceptions
    set_exception_handler(function (Throwable|Exception|Error $exception) {
      Console::reset();
      $this->handleException($exception);
    });

    // Handle errors
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
      Console::reset();
      $this->handleError($errno, $errstr, $errfile, $errline);
    });
  }

  /**
   * Destruct the game engine.
   */
  public function __destruct()
  {
    Console::restoreTerminalSettings();

    if (!empty($this->errors))
    {
      foreach ($this->errors as $error)
      {
        echo $error . PHP_EOL;
      }
    }
    else
    {
      Console::reset();
    }
  }

  /**
   * Load game settings.
   *
   * @param array<string, mixed>|null $settings The settings to load. If null will load default settings.
   * @return $this The current instance of the game engine.
   */
  public function loadSettings(?array $settings = null): self
  {
    try
    {
      Debug::info("Loading game settings");
      $this->settings['name']                   = $settings['name'] ?? $this->name;
      $this->settings['screen_width']           = $settings['screen_width'] ?? $this->screenWidth;
      $this->settings['screen_height']          = $settings['screen_height'] ?? $this->screenHeight;
      $this->settings['fps']                    = $settings['fps'] ?? DEFAULT_FPS;
      $this->settings['assets_path']            = $settings['assets_path'] ?? getcwd() . DEFAULT_ASSETS_PATH;

      Debug::info("Loading scene settings");
      $this->settings['initial_scene']          = 0 ?? throw new InitializationException("Initial scene not found");

      Debug::info("Loading splash screen settings");
      if (isset($settings['splash_texture']))
      {
        $this->settings['splash_texture'] = Path::join(getcwd(), $settings['splash_texture']);
      }

      $this->settings['splash_screen_duration'] = $settings['splash_screen_duration'] ?? DEFAULT_SPLASH_SCREEN_DURATION;

      Debug::info("Loading environment settings");
      $this->settings['debug']                  = $_ENV['DEBUG_MODE'] ?? false;
      $this->settings['log_level']              = $_ENV['LOG_LEVEL'] ?? DEFAULT_LOG_LEVEL;
      $this->settings['log_dir']                = $_ENV['LOG_DIR'] ?? Path::join(getcwd(), DEFAULT_LOGS_DIR);

      // Debug settings
      Debug::setLogDirectory($this->settings['log_dir']);
      Debug::setLogLevel(LogLevel::tryFrom($this->settings['log_level']) ?? LogLevel::DEBUG);

      Debug::info("Game settings loaded");
    }
    catch (Exception $exception)
    {
      $this->handleException($exception);
    }

    return $this;
  }

  /**
   * @return array<string, mixed>
   */
  public function getSettings(): array
  {
    return $this->settings;
  }

  /**
   * Run the game.
   *
   * @return void
   */
  public function run(): void
  {
    try
    {
      $sleepTime = (int)(1000000 / $this->settings['fps']);
      $this->start();
      $nextFrameTime = microtime(true) + 1;
      $lastFrameCountSnapShot = $this->frameCount;

      Debug::info("Running game");
      while ($this->isRunning)
      {
        $this->handleInput();
        $this->update();
        $this->render();

        usleep($sleepTime);

        if (microtime(true) >= $nextFrameTime)
        {
          $this->frameRate = $this->frameCount - $lastFrameCountSnapShot;
          $lastFrameCountSnapShot = $this->frameCount;
          $nextFrameTime = microtime(true) + 1;
        }
      }
    }
    catch (Exception $exception)
    {
      $this->handleException($exception);
    }
  }

  /**
   * Start the game.
   *
   * @return void
   */
  private function start(): void
  {
    Debug::info("Starting game");

    // Save the terminal settings
    Console::saveTerminalSettings();

    // Set the terminal name
    Console::setTerminalName($this->settings['name']);

    // Set the terminal size
    Console::setTerminalSize($this->settings['screen_width'], $this->settings['screen_height']);

    // Hide the cursor
    Console::cursor()->hide();

    // Disable echo
    InputManager::disableEcho();

    // Enable non-blocking input mode
    InputManager::enableNonBlockingMode();

    // Show the splash screen
    $this->showSplashScreen();

    // Handle game events
    $this->handleGameEvents();

    // Load the first scene
    try
    {
      $this->sceneManager->loadScene($this->settings['initial_scene']);
    }
    catch (SceneNotFoundException $exception)
    {
      $this->handleException($exception);
    }

    // Add game observers
    $this->addObservers(Time::class);

    // Start the game
    $this->isRunning = true;

    // Notify listeners that the game has started
    $this->notify(new GameEvent(GameEventType::START));

    Debug::info("Game started");
  }

  /**
   * Stop the game.
   *
   * @return void
   */
  public function stop(): void
  {
    Debug::info("Stopping game");

    // Disable non-blocking input mode
    InputManager::disableNonBlockingMode();

    // Enable echo
    InputManager::enableEcho();

    // Show cursor
    Console::cursor()->show();

    // Restore the terminal settings
    Console::restoreTerminalSettings();

    // Remove observers
    $this->removeObservers();

    // Stop the game
    $this->isRunning = false;

    // Notify listeners that the game has stopped
    $this->notify(new GameEvent(GameEventType::STOP));

    Debug::info("Game stopped");
  }

  /**
   * Handle game input.
   *
   * @return void
   */
  private function handleInput(): void
  {
    InputManager::handleInput();
  }

  /**
   * Update the game state.
   *
   * @return void
   */
  private function update(): void
  {
    if ($this->isShowingModal)
    {
      $this->modalManager->update();
    }
    else
    {
      $this->sceneManager->update();
      $this->notificationsManager->update();
    }

    $this->uiManager->update();

    $this->notify(new GameEvent(GameEventType::UPDATE));
  }

  /**
   * Render the game.
   *
   * @return void
   */
  private function render(): void
  {
    $this->frameCount++;

    if ($this->isShowingModal)
    {
      $this->modalManager->render();
    }
    else
    {
      $this->sceneManager->render();
    }

    $this->uiManager->render();

    if ($this->settings['debug'])
    {
      $this->renderDebugInfo();
    }

    $this->notify(new GameEvent(GameEventType::RENDER));
  }

  /**
   * Handles game errors.
   *
   * @param int $errno
   * @param string $errstr
   * @param string $errfile
   * @param int $errline
   * @return never
   */
  private function handleError(int $errno, string $errstr, string $errfile, int $errline): never
  {
    $errorMessage = "[$errno] $errstr in $errfile on line $errline";
    Debug::error($errorMessage);
    $this->stop();
    exit($errorMessage);
  }


  /**
   * Handle game exceptions.
   *
   * @param Exception|Throwable|Error $exception The exception to be handled.
   * @return never
   */
  private function handleException(Exception|Throwable|Error $exception): never
  {
    $this->errors[] = $exception;
    Debug::error($exception);
    $this->stop();
    exit($exception);
  }

  /**
   * @inheritDoc
   */
  public function addObservers(ObserverInterface|StaticObserverInterface|string ...$observers): void
  {
    foreach ($observers as $observer)
    {
      if ($observer instanceof ObserverInterface)
      {
        $this->observers->add($observer);
      }
      else
      {
        $this->staticObservers->add($observer);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(ObserverInterface|StaticObserverInterface|string|null ...$observers): void
  {
    if (is_null($observers))
    {
      $this->observers->clear();
      $this->staticObservers->clear();
      return;
    }

    foreach ($observers as $observer)
    {
      if ($observer instanceof ObserverInterface)
      {
        $this->observers->remove($observer);
      }
      else
      {
        $this->staticObservers->remove($observer);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    try
    {
      /** @var ObserverInterface $observer */
      foreach ($this->observers as $observer)
      {
        $observer->onNotify($this, $event);
      }

      /** @var StaticObserverInterface $observer */
      foreach ($this->staticObservers as $observer)
      {
        $observer::onNotify($this, $event);
      }
    }
    catch (Exception $exception)
    {
      $this->handleException($exception);
    }
  }

  /**
   * @param SceneInterface ...$scenes
   * @return $this
   */
  public function addScenes(SceneInterface ...$scenes): self
  {
    foreach ($scenes as $scene)
    {
      $this->sceneManager->addScene($scene);
    }

    return $this;
  }

  /**
   * @return void
   */
  private function showSplashScreen(): void
  {
    try
    {
      Debug::info("Showing splash screen");

      // Check if a splash texture can be loaded
      if (!file_exists($this->settings['splash_texture']))
      {
        Debug::warn("Splash screen texture not found: {$this->settings['splash_texture']}");
        $this->settings['splash_texture'] = Path::join(Path::getAssetsDirectory(), DEFAULT_SPLASH_TEXTURE_PATH);
      }

      Debug::info("Loading splash screen texture");
      $splashScreen = file_get_contents($this->settings['splash_texture']);
      $splashScreenRows = explode("\n", $splashScreen);
      $splashByLine = 'SendamaEngine ™';
      $splashScreenRows[] = sprintf("%s%s", str_repeat(' ', 75 - 12), "powered by");
      $splashScreenRows[] = sprintf("%s%s", str_repeat(' ', 75 - strlen($splashByLine)), $splashByLine);

      $leftMargin = (DEFAULT_SCREEN_WIDTH  / 2) - (75 / 2);
      $topMargin = (DEFAULT_SCREEN_HEIGHT / 2) - (25 / 2);

      Debug::info("Rendering splash screen texture");
      foreach ($splashScreenRows as $rowIndex => $row)
      {
        Console::write($row, (int)$leftMargin, (int)($topMargin + $rowIndex));
      }

      $duration = (int) ($this->settings['splash_screen_duration'] * 1000000);
      usleep($duration);
      Console::clear();

      Debug::info("Splash screen hidden");
    }
    catch (Exception $exception)
    {
      $this->handleException($exception);
    }
  }

  /**
   * @return void
   */
  private function handleGameEvents(): void
  {
    try
    {
      // Handle game events
      $this->eventManager->addEventListener(EventType::GAME, function (GameEvent $event) {
        Debug::log("Game event received");
        switch ($event->gameEventType)
        {
          case GameEventType::QUIT:
            Debug::info("Game quit event received");
            $this->notify(new GameEvent(GameEventType::QUIT));
            $this->stop();
            break;

          default:
            break;
        }
      });

    }
    catch (Exception $exception)
    {
      $this->handleException($exception);
    }
  }

  /**
   * Renders Debug Info.
   *
   * @return void
   */
  private function renderDebugInfo(): void
  {
    // TODO: Implement renderDebugInfo()
    $content = [
      "FPS: $this->frameRate",
      "Delta: " . round(Time::getDeltaTime(), 2),
      "Time: " . Time::getPrettyTime(ChronoUnit::SECONDS)
    ];
  }

  /**
   * Initialize game settings.
   *
   * @return void
   */
  private function initializeSettings(): void
  {
    $this->settings['name']                   = $this->name;
    $this->settings['screen_width']           = $this->screenWidth;
    $this->settings['screen_height']          = $this->screenHeight;
    $this->settings['fps']                    = DEFAULT_FPS;
    $this->settings['assets_path']            = Path::join(getcwd(), DEFAULT_ASSETS_PATH);

    $this->settings['initial_scene']          = null;

    // Splash screen settings
    $this->settings['splash_texture']         = Path::join($this->settings['assets_path'], basename(DEFAULT_SPLASH_TEXTURE_PATH));
    Debug::log("Splash screen texture init: {$this->settings['splash_texture']}");
    $this->settings['splash_screen_duration'] = DEFAULT_SPLASH_SCREEN_DURATION;

    // Load environment settings
    $this->settings['debug']                  = $_ENV['DEBUG_MODE'] ?? false;
    $this->settings['log_level']              = $_ENV['LOG_LEVEL'] ?? 'info';
    $this->settings['log_dir']                = Path::join(getcwd(), DEFAULT_LOGS_DIR);
    Debug::log("Log directory initialized: {$this->settings['log_dir']}");

    // Debug settings
    Debug::setLogDirectory($this->settings['log_dir']);
    Debug::setLogLevel(LogLevel::tryFrom($this->settings['log_level']) ?? LogLevel::DEBUG);

    Debug::info("Game settings initialized");
  }

  /**
   * Quit the game.
   *
   * @return void
   */
  public static function quit(): void
  {
    if (confirm("Are you sure you want to quit?", "", 40))
    {
      EventManager::getInstance()->dispatchEvent(new GameEvent(GameEventType::QUIT));
    }
  }

}