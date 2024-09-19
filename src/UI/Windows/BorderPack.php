<?php

namespace Sendama\Engine\UI\Windows;

use Sendama\Engine\Debug\Debug;
use Sendama\Engine\UI\Windows\Interfaces\BorderPackInterface;

/**
 * Class BorderPack. Represents a border pack.
 *
 * @package Sendama\Engine\UI\Windows
 * @noinspection PhpUnused
 */
class BorderPack implements BorderPackInterface
{
  /**
   * The file extension of the border pack.
   *
   * @var string
   */
  public const string FILE_EXTENSION = 'border.php';

  /**
   * The top left corner.
   *
   * @var string
   */
  protected string $topLeftCorner = '╔';
  /**
   * The top right corner.
   *
   * @var string
   */
  protected string $topRightCorner = '╗';
  /**
   * The bottom left corner.
   *
   * @var string
   */
  protected string $bottomLeftCorner = '╚';
  /**
   * The bottom right corner.
   *
   * @var string
   */
  protected string $bottomRightCorner = '╝';
  /**
   * The top horizontal connector.
   *
   * @var string
   */
  protected string $horizontalBorder = '═';
  /**
   * The vertical border.
   *
   * @var string
   */
  protected string $verticalBorder = '║';
  /**
   * The top horizontal connector.
   *
   * @var string
   */
  protected string $topHorizontalConnector = '╦';
  /**
   * The bottom horizontal connector.
   *
   * @var string
   */
  protected string $bottomHorizontalConnector = '╩';
  /**
   * The left vertical connector.
   *
   * @var string
   */
  protected string $leftVerticalConnector = '╠';
  /**
   * The right vertical connector.
   *
   * @var string
   */
  protected string $rightVerticalConnector = '╣';
  /**
   * The center connector.
   *
   * @var string
   */
  protected string $centerConnector = '╬';

  /**
   * BorderPack constructor.
   *
   * @param string $path The path to the border pack.
   */
  public function __construct(
    protected string $path
  )
  {
    $this->loadTextures();
  }

  /**
   * @inheritDoc
   */
  public function getTopLeftCorner(): string
  {
    return $this->topLeftCorner;
  }

  /**
   * @inheritDoc
   */
  public function getTopRightCorner(): string
  {
    return $this->topRightCorner;
  }

  /**
   * @inheritDoc
   */
  public function getBottomLeftCorner(): string
  {
    return $this->bottomLeftCorner;
  }

  /**
   * @inheritDoc
   */
  public function getBottomRightCorner(): string
  {
    return $this->bottomRightCorner;
  }

  /**
   * @inheritDoc
   */
  public function getHorizontalBorder(): string
  {
    return $this->horizontalBorder;
  }

  /**
   * @inheritDoc
   */
  public function getVerticalBorder(): string
  {
    return $this->verticalBorder;
  }

  /**
   * @inheritDoc
   */
  public function getTopHorizontalConnector(): string
  {
    return $this->topHorizontalConnector;
  }

  /**
   * @inheritDoc
   */
  public function getBottomHorizontalConnector(): string
  {
    return $this->bottomHorizontalConnector;
  }

  /**
   * @inheritDoc
   */
  public function getLeftVerticalConnector(): string
  {
    return $this->leftVerticalConnector;
  }

  /**
   * @inheritDoc
   */
  public function getRightVerticalConnector(): string
  {
    return $this->rightVerticalConnector;
  }

  /**
   * @inheritDoc
   */
  public function getCenterConnector(): string
  {
    return $this->centerConnector;
  }

  /**
   * Loads the textures of the border pack.
   *
   * @return void
   */
  protected function loadTextures(): void
  {
    if (! file_exists($this->path) ) {
      Debug::warn("The border pack path '$this->path' does not exist.");
      return;
    }

    if (! str_ends_with($this->path, self::FILE_EXTENSION) ) {
      Debug::warn("The border pack path '$this->path' does not have the correct file extension.");
      return;
    }

    /**
     * @var array{
     *   corners: array{top_left: string, top_right: string, bottom_left: string, bottom_right: string},
     *   borders: array{horizontal: string, vertical: string},
     *   connectors: array{top_horizontal: string, bottom_horizontal: string, left_vertical: string, right_vertical: string}
     * } $borderPack
     */
    $borderPack = require $this->path;

    if (! is_array($borderPack) ) {
      Debug::warn("The border pack path '$this->path' does not return an array.");
      return;
    }

    if (
      ! key_exists('corners', $borderPack) ||
      ! key_exists('borders', $borderPack) ||
      ! key_exists('connectors', $borderPack)
    ) {
      Debug::warn("The border pack path '$this->path' does not have the correct keys.");
      return;
    }

    $this->bottomRightCorner          = $borderPack['corners']['bottom_right'] ?? $this->bottomRightCorner;
    $this->bottomLeftCorner           = $borderPack['corners']['bottom_left'] ?? $this->bottomLeftCorner;
    $this->topRightCorner             = $borderPack['corners']['top_right'] ?? $this->topRightCorner;
    $this->topLeftCorner              = $borderPack['corners']['top_left'] ?? $this->topLeftCorner;
    $this->leftVerticalConnector      = $borderPack['connectors']['left_vertical'] ?? $this->leftVerticalConnector;
    $this->rightVerticalConnector     = $borderPack['connectors']['right_vertical'] ?? $this->rightVerticalConnector;
    $this->topHorizontalConnector     = $borderPack['connectors']['top_horizontal'] ?? $this->topHorizontalConnector;
    $this->bottomHorizontalConnector  = $borderPack['connectors']['bottom_horizontal'] ?? $this->bottomHorizontalConnector;
    $this->centerConnector            = $borderPack['connectors']['center'] ?? $this->centerConnector;
    $this->verticalBorder             = $borderPack['borders']['vertical'] ?? $this->verticalBorder;
    $this->horizontalBorder           = $borderPack['borders']['horizontal'] ?? $this->horizontalBorder;
  }
}