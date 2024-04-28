<?php

namespace Sendama\Engine\Core;

/**
 * Represents a 2D texture.
 */
class Texture2D
{
  /**
   * The pixels of the texture.
   *
   * @var string[] The pixels of the texture.
   */
  protected array $pixels = [];

  /**
   * Creates a new instance of the Texture2D class.
   *
   * @param string $path   The path to the image file.
   * @param int    $width  The width of the texture.
   * @param int    $height The height of the texture.
   */
  public function __construct(
    private readonly string $path,
    private readonly int    $width = 1,
    private readonly int    $height = 1,
  )
  {
    if (!file_exists($this->path))
    {
      throw new \InvalidArgumentException("The file '$this->path' does not exist.");
    }

    // Load the image.
    $this->loadImage();
  }

  /**
   * Returns the pixel at the specified coordinates.
   *
   * @param int $x The x coordinate.
   * @param int $y The y coordinate.
   * @return string The pixel at the specified coordinates.
   */
  public function getPixel(int $x, int $y): string
  {
    if (!isset($this->pixels[$y][$x]))
    {
      throw new \InvalidArgumentException("The pixel at ($x, $y) does not exist.");
    }

    return $this->pixels[$y][$x];
  }

  /**
   * Sets the pixel at the specified coordinates.
   *
   * @param int    $x     The x coordinate.
   * @param int    $y     The y coordinate.
   * @param string $pixel The pixel to set.
   */
  public function setPixel(int $x, int $y, string $pixel): void
  {
    if ($x < 0 || $x >= $this->width || $y < 0 || $y >= $this->height)
    {
      throw new \InvalidArgumentException("The pixel at ($x, $y) does not exist.");
    }

    $this->pixels[$y][$x] = substr($pixel, 0, 1);
  }

  /**
   * Loads the image from the specified path.
   */
  protected function loadImage(): void
  {
    // Load the image.
    $image = file_get_contents($this->path);

    // Convert the image to an array of pixels.
    $imageMatrix = explode("\n", $image);

    foreach ($imageMatrix as $row)
    {
      $this->pixels[] = str_split(substr($row, 0, $this->width));
    }
  }
}