<?php

namespace Sendama\Engine\Core;

use RuntimeException;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use SplFixedArray;

/**
 * Class TileManager
 *
 * @package Sendama\Engine\Core
 */
class TileManager implements SingletonInterface
{
  /**
   * @var TileManager|null $instance The instance of the TileManager class.
   */
  protected static ?self $instance = null;

  /**
   * @var array{width: int, height: int} $settings The settings for the TileManager.
   */
  protected array $settings = [];
  /**
   * @var SplFixedArray<Sprite> $tiles The tiles for the TileManager.
   */
  private SplFixedArray $tiles;

  /**
   * TileManager constructor.
   */
  private function __construct()
  {
    // This is a private constructor to prevent users from creating a new instance of the TileManager class.
    $this->settings = [
      'width' => DEFAULT_SCREEN_WIDTH,
      'height' => DEFAULT_SCREEN_HEIGHT
    ];
    $this->tiles = $this->getInitializedTilesArray($this->settings['width'], $this->settings['height']);
  }

  /**
   * @inheritDoc
   *
   * @return self
   */
  public static function getInstance(): self
  {
    if (!self::$instance)
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Loads the settings for the TileManager.
   *
   * @param array{width: int, height: int} $settings The settings to load.
   */
  public function loadSettings(array $settings = []): void
  {
    foreach ($settings as $key => $value)
    {
      if (key_exists($key, $this->settings))
      {
        $this->settings[$key] = $value;
      }
    }
  }

  /**
   * Gets an initialized array of tiles.
   *
   * @param mixed $width The width of the tiles array.
   * @param mixed $height The height of the tiles array.
   * @return SplFixedArray<Sprite>
   */
  private function getInitializedTilesArray(mixed $width, mixed $height): SplFixedArray
  {
    $array = new SplFixedArray($height);

    for ($i = 0; $i < $height; $i++)
    {
      $array[$i] = new SplFixedArray($width);
    }

    return $array;
  }

  public function setTile(Sprite $sprite, int $x, int $y): void
  {

  }

  public function getTile(int $x, int $y): Sprite
  {
    if (!isset($this->tiles[$x]))
    {
      throw new RuntimeException("Invalid x coordinate: $x");
    }

    if (! $this->tiles[$x]->offsetGet($y) )
    {
      throw new RuntimeException("Invalid y coordinate: $y");
    }

    return $this->tiles[$x]->offsetGet($y);
  }
}