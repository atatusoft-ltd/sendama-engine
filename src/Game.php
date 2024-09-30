<?php

namespace Sendama\Engine;

use Assegai\Collections\ItemList;
use Dotenv\Dotenv;
use Error;
use Exception;
use Sendama\Engine\Core\Enumerations\ChronoUnit;
use Sendama\Engine\Core\Scenes\Interfaces\SceneInterface;
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
use Sendama\Engine\Interfaces\GameStateInterface;
use Sendama\Engine\IO\Console\Console;
use Sendama\Engine\IO\Console\Cursor;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\InputManager;
use Sendama\Engine\Messaging\Notifications\NotificationsManager;
use Sendama\Engine\States\GameState;
use Sendama\Engine\States\ModalState;
use Sendama\Engine\States\PausedState;
use Sendama\Engine\States\SceneState;
use Sendama\Engine\UI\Modals\ModalManager;
use Sendama\Engine\UI\UIManager;
use Sendama\Engine\UI\Windows\Window;
use Sendama\Engine\Util\Path;
use Throwable;

/**
 * The main Game engine class.
 *
 * @package Sendama\Engine;
 */
class Game implements ObservableInterface
{
  const int DEBUG_WINDOW_HEIGHT = 5;
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
  /**
   * @var Cursor $consoleCursor
   */
  private Cursor $consoleCursor;

  /**
   * @var Window $debugWindow
   */
  private Window $debugWindow;

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
   * @var GameStateInterface $state
   */
  private GameStateInterface $state;
  /**
   * @var SceneState $sceneState
   */
  protected SceneState $sceneState;
  /**
   * @var ModalState $modalState
   */
  protected ModalState $modalState;
  /**
   * @var PausedState $pausedState
   */
  protected PausedState $pausedState;
  /**
   * @var GameState|null $previousState The previous state of the game.
   */
  protected ?GameState $previousState = null;

  /**
   * Game constructor.
   *
   * @param string $name The name of the game.
   * @param int $screenWidth The width of the game screen.
   * @param int $screenHeight The height of the game screen.
   * @throws Exception
   */
  public function __construct(
    private readonly string $name,
    private readonly int $screenWidth = DEFAULT_SCREEN_WIDTH,
    private readonly int $screenHeight = DEFAULT_SCREEN_HEIGHT,
    private readonly ?string $workingDirectory = null
  )
  {
    // Load environment variables
    if (file_exists($this->workingDirectory ?? getcwd() . '/.env')) {
      $dotenv = Dotenv::createImmutable(getcwd());
      $dotenv->load();
    }

    // Initialize console
    Console::init();

    // Initialize managers
    $this->consoleCursor        = Console::cursor();
    $this->sceneManager         = SceneManager::getInstance();
    $this->eventManager         = EventManager::getInstance();
    $this->modalManager         = ModalManager::getInstance();
    $this->notificationsManager = NotificationsManager::getInstance();
    $this->uiManager            = UIManager::getInstance();

    $this->debugWindow          = new Window();

    // Initialize observers
    $this->observers            = new ItemList(ObserverInterface::class);
    $this->staticObservers      = new ItemList(StaticObserverInterface::class);

    // Load default settings
    $this->initializeSettings();

    $this->sceneState           = new SceneState(
      $this,
      $this->sceneManager,
      $this->eventManager,
      $this->modalManager,
      $this->notificationsManager,
      $this->uiManager
    );
    $this->modalState           = new ModalState(
      $this,
      $this->sceneManager,
      $this->eventManager,
      $this->modalManager,
      $this->notificationsManager,
      $this->uiManager
    );
    $this->pausedState          = new PausedState(
      $this,
      $this->sceneManager,
      $this->eventManager,
      $this->modalManager,
      $this->notificationsManager,
      $this->uiManager
    );
    $this->state = $this->sceneState;

    // Handle Signals
    pcntl_signal(SIGWINCH, function () {
      $terminalSize             = Console::getSize();
      $currentScreenWidth       = $terminalSize->getWidth();
      $currentScreenHeight      = $terminalSize->getHeight();

      $this->screenWidth        = min($currentScreenWidth, $this->screenWidth, DEFAULT_SCREEN_WIDTH);
      $this->screenHeight       = min($currentScreenHeight, $this->screenHeight, DEFAULT_SCREEN_HEIGHT);

      Debug::info("SIGWINCH received");
    });

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
    Console::restoreSettings();

    if (!empty($this->errors)) {
      foreach ($this->errors as $error) {
        echo $error . PHP_EOL;
      }
    } else {
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
    try {
      Debug::info("Loading environment settings");
      // Environment
      $this->settings['debug']                  = $_ENV['DEBUG_MODE'] ?? false;
      $this->settings['debug_info']             = $_ENV['SHOW_DEBUG_INFO'] ?? false;
      $this->settings['log_level']              = $_ENV['LOG_LEVEL'] ?? DEFAULT_LOG_LEVEL;
      $this->settings['log_dir']                = $_ENV['LOG_DIR'] ?? Path::join(getcwd(), DEFAULT_LOGS_DIR);

      Debug::info("Loading game settings");
      // Game
      $this->settings['game_name']              = $settings['game_name'] ?? $this->name;
      $this->settings['screen_width']           = $settings['screen_width'] ?? $this->screenWidth;
      $this->settings['screen_height']          = $settings['screen_height'] ?? $this->screenHeight;
      $this->settings['fps']                    = $settings['fps'] ?? DEFAULT_FPS;
      $this->settings['assets_path']            = $settings['assets_path'] ?? getcwd() . DEFAULT_ASSETS_PATH;

      Debug::info('Loading scene settings');
      // Scene
      $this->settings['initial_scene']          = 0 ?? throw new InitializationException("Initial scene not found");

      Debug::info('Loading splash screen settings');
      if (isset($settings['splash_texture'])) {
        $this->settings['splash_texture'] = Path::join(getcwd(), $settings['splash_texture']);
      }

      $this->settings['splash_screen_duration'] = $settings['splash_screen_duration'] ?? DEFAULT_SPLASH_SCREEN_DURATION;

      // Debug settings
      Debug::info('Loading debug settings');
      Debug::setLogDirectory($this->getSettings('log_dir'));
      Debug::setLogLevel(LogLevel::tryFrom($this->getSettings('log_level')) ?? LogLevel::DEBUG);
      $this->debugWindow->setPosition([0, $this->settings['screen_height'] - self::DEBUG_WINDOW_HEIGHT]);

      $this->sceneManager->loadSettings($this->settings);
      Debug::info("Game settings loaded");
    } catch (Exception $exception) {
      $this->handleException($exception);
    }

    return $this;
  }

  /**
   * Retrieve game settings.
   *
   * @param string|null $key The key of the setting to retrieve.
   * @return mixed The game settings.
   */
  public function getSettings(?string $key = null): mixed
  {
    return $this->settings[$key] ?? $this->settings;
  }

  /**
   * Run the game.
   *
   * @return void
   */
  public function run(): void
  {
    try {
      $sleepTime = (int)(1000000 / $this->getSettings('fps'));
      $this->start();
      $nextFrameTime = microtime(true) + 1;
      $lastFrameCountSnapShot = $this->frameCount;

      Debug::info("Running game");
      while ($this->isRunning) {
        $this->handleInput();
        $this->update();
        $this->render();

        usleep($sleepTime);

        if (microtime(true) >= $nextFrameTime) {
          $this->frameRate = $this->frameCount - $lastFrameCountSnapShot;
          $lastFrameCountSnapShot = $this->frameCount;
          $nextFrameTime = microtime(true) + 1;
        }
      }
    } catch (Exception $exception) {
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
    Console::saveSettings();

    // Set the terminal name
    Console::setName($this->getSettings('game_name'));

    // Set the terminal size
    Console::setSize($this->getSettings('screen_width'), $this->getSettings('screen_height'));

    // Hide the cursor
    $this->consoleCursor->hide();

    // Disable echo
    InputManager::disableEcho();

    // Enable non-blocking input mode
    InputManager::enableNonBlockingMode();

    // Show the splash screen
    $this->showSplashScreen();

    // Handle game events
    $this->handleGameEvents();

    // Load the first scene
    try {
      $this->sceneManager->loadScene($this->getSettings('initial_scene'));
    } catch (SceneNotFoundException $exception) {
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
    $this->consoleCursor->show();

    // Restore the terminal settings
    Console::restoreSettings();

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
    $this->state->update();

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

    $this->state->render();

    $this->uiManager->render();

    $this->renderDebugInfo();

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

    if ($this->getSettings('debug')) {
      exit($errorMessage);
    }

    exit($errno);
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

    if ($this->getSettings('debug')) {
      exit($exception);
    }

    exit($exception->getCode());
  }

  /**
   * @inheritDoc
   */
  public function addObservers(ObserverInterface|StaticObserverInterface|string ...$observers): void
  {
    foreach ($observers as $observer) {
      if ($observer instanceof ObserverInterface) {
        $this->observers->add($observer);
      } else {
        $this->staticObservers->add($observer);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(ObserverInterface|StaticObserverInterface|string|null ...$observers): void
  {
    if (is_null($observers)) {
      $this->observers->clear();
      $this->staticObservers->clear();
      return;
    }

    foreach ($observers as $observer) {
      if ($observer instanceof ObserverInterface) {
        $this->observers->remove($observer);
      } else {
        $this->staticObservers->remove($observer);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    try {
      /** @var ObserverInterface $observer */
      foreach ($this->observers as $observer) {
        $observer->onNotify($this, $event);
      }

      /** @var StaticObserverInterface $observer */
      foreach ($this->staticObservers as $observer) {
        $observer::onNotify($this, $event);
      }
    } catch (Exception $exception) {
      $this->handleException($exception);
    }
  }

  /**
   * Add scenes to the game.
   *
   * @param SceneInterface ...$scenes The scenes to add.
   * @return $this
   */
  public function addScenes(SceneInterface ...$scenes): self
  {
    foreach ($scenes as $scene) {
      $this->sceneManager->addScene($scene);
    }

    return $this;
  }

  /**
   * Set the current game state.
   *
   * @param GameStateInterface $state The game state to set.
   * @return void
   */
  public function setState(GameStateInterface $state): void
  {
    $this->previousState = $this->state;
    $this->state = $state;
  }

  /**
   * Retrieve a game state.
   *
   * @param string $stateName The name of the state to retrieve.
   * @return GameStateInterface|null The game state or null if not found.
   */
  public function getState(string $stateName): ?GameStateInterface
  {
    return match ($stateName) {
      'scene' => $this->sceneState,
      'modal' => $this->modalState,
      'paused' => $this->pausedState,
      default => null
    };
  }

  /**
   * Display the splash screen.
   *
   * @return void
   */
  private function showSplashScreen(): void
  {
    try {
      Debug::info("Showing splash screen");
      Console::setSize(MAX_SCREEN_WIDTH, MAX_SCREEN_HEIGHT);

      // Check if a splash texture can be loaded
      if (!file_exists($this->getSettings('splash_texture'))) {
        Debug::warn("Splash screen texture not found: {$this->settings['splash_texture']}");
        $this->settings['splash_texture'] = Path::join(Path::getVendorAssetsDirectory(), DEFAULT_SPLASH_TEXTURE_PATH);
      }

      Debug::info("Loading splash screen texture");
      $splashScreen = file_get_contents($this->getSettings('splash_texture'));
      $splashScreenRows = explode("\n", $splashScreen);
      $splashScreenWidth = 75;
      $splashScreenHeight = 25;
      $splashByLine = 'SendamaEngine ™';
      $splashScreenRows[] = sprintf("%s%s", str_repeat(' ', $splashScreenWidth - 12), "powered by");
      $splashScreenRows[] = sprintf("%s%s", str_repeat(' ', $splashScreenWidth - strlen($splashByLine)), $splashByLine);

      $leftMargin = (MAX_SCREEN_WIDTH  / 2) - ($splashScreenWidth / 2);
      $topMargin = (MAX_SCREEN_HEIGHT / 2) - ($splashScreenHeight / 2);

      Debug::info("Rendering splash screen texture");
      foreach ($splashScreenRows as $rowIndex => $row) {
        $this->consoleCursor->moveTo((int)$leftMargin, (int)($topMargin + $rowIndex));
        Console::output()->write($row);
      }

      $duration = (int) ($this->getSettings('splash_screen_duration') * 1000000);
      usleep($duration);

      Console::setSize($this->getSettings('screen_width'), $this->getSettings('screen_height'));
      Console::clear();

      Debug::info("Splash screen hidden");
    } catch (Exception $exception) {
      $this->handleException($exception);
    }
  }

  /**
   * @return void
   */
  private function handleGameEvents(): void
  {
    try {
      // Handle game events
      $this->eventManager->addEventListener(EventType::GAME, function (GameEvent $event) {
        Debug::info("Game event received");
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

    } catch (Exception $exception) {
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
    if ($this->isDebug() && $this->showDebugInfo()) {
      $content = [
        "FPS: $this->frameRate",
        "Delta: " . round(Time::getDeltaTime(), 2),
        "Time: " . Time::getPrettyTime(ChronoUnit::SECONDS)
      ];

      $this->debugWindow->setContent($content);
      $this->debugWindow->render();
    }
  }

  /**
   * Initialize game settings.
   *
   * @return void
   */
  private function initializeSettings(): void
  {
    $this->settings['game_name']              = $_ENV['GAME_NAME'] ?? $this->name;
    $this->settings['screen_width']           = $this->screenWidth;
    $this->settings['screen_height']          = $this->screenHeight;
    $this->settings['fps']                    = DEFAULT_FPS;
    $this->settings['assets_path']            = Path::join(getcwd(), DEFAULT_ASSETS_PATH);

    $this->settings['initial_scene']          = null;

    // Load environment settings
    $this->settings['debug']                  = $_ENV['DEBUG_MODE'] ?? false;
    $this->settings['debug_info']             = $_ENV['SHOW_DEBUG_INFO'] ?? false;
    $this->settings['log_level']              = $_ENV['LOG_LEVEL'] ?? 'info';
    Debug::setLogLevel(LogLevel::tryFrom($this->getSettings('log_level')) ?? LogLevel::DEBUG);

    $this->settings['log_dir']                = Path::join(getcwd(), DEFAULT_LOGS_DIR);
    Debug::info("Log directory initialized: {$this->settings['log_dir']}");

    // Debug settings
    Debug::setLogDirectory($this->getSettings('log_dir'));
    $this->debugWindow->setPosition([0, $this->settings['screen_height'] - self::DEBUG_WINDOW_HEIGHT]);

    // Input settings
    $this->settings['buttons']                = [];
    $this->settings['pause_key']              = $_ENV['PAUSE_KEY'] ?? KeyCode::ESCAPE;

    // Splash screen settings
    $this->settings['splash_texture']         = Path::join($this->settings['assets_path'], basename(DEFAULT_SPLASH_TEXTURE_PATH));
    Debug::info("Splash screen texture init: {$this->settings['splash_texture']}");
    $this->settings['splash_screen_duration'] = DEFAULT_SPLASH_SCREEN_DURATION;

    $this->sceneManager->loadSettings($this->settings);
    Debug::info("Game settings initialized");
  }

  public function getPreviousState(): GameState
  {
    return $this->previousState;
  }

  /**
   * Quit the game.
   *
   * @return void
   */
  public static function quit(): void
  {
    if (confirm("Are you sure you want to quit?", "", 40)) {
      EventManager::getInstance()->dispatchEvent(new GameEvent(GameEventType::QUIT));
    }
  }

  /**
   * Get the debug status.
   *
   * @return bool The debug status.
   */
  private function isDebug(): bool
  {
    return match (gettype($this->getSettings('debug'))) {
      'boolean' => $this->getSettings('debug'),
      'string'  => strtolower($this->getSettings('debug')) === 'true',
      'integer' => $this->getSettings('debug') === 1,
      default   => false
    };
  }

  private function showDebugInfo(): bool
  {
    return match (gettype($this->getSettings('debug_info'))) {
      'boolean' => $this->getSettings('debug_info'),
      'string'  => strtolower($this->getSettings('debug_info')) === 'true',
      'integer' => $this->getSettings('debug_info') === 1,
      default   => false
    };
  }
}