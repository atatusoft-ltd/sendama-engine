<?php

namespace Sendama\Engine\Core;

use InvalidArgumentException;
use Sendama\Engine\Core\Interfaces\CanCompare;
use Sendama\Engine\Core\Interfaces\CanEquate;
use Sendama\Engine\Core\Interfaces\GridInterface;

/**
 * Represents a grid.
 *
 * @template T
 * @implements GridInterface<T>
 */
class Grid implements GridInterface
{
  private const mixed INITIAL_VALUE = 0;

  protected string $hash;
  /**
   * @var T[][] $grid The grid.
   */
  protected array $grid = [];

  /**
   * Constructs a grid.
   *
   * @param int $width The width of the grid.
   * @param int $height The height of the grid.
   */
  public function __construct(
    protected int $width = DEFAULT_GRID_WIDTH,
    protected int $height = DEFAULT_GRID_HEIGHT,
    protected int|string $initialValue = self::INITIAL_VALUE
  )
  {
    $this->hash = uniqid(__CLASS__, true) . '-' . md5(__CLASS__);
    $this->grid = array_fill(0, $this->height, array_fill(0, $this->width, $this->initialValue));
  }

  /**
   * @inheritDoc
   */
  public function compareTo(CanCompare $other): int
  {
    if (! $other instanceof Grid)
    {
      throw new InvalidArgumentException('The other object must be an instance of Grid.');
    }

    return match (true) {
      $this->getWidth() > $other->getWidth() => 1,
      $this->getWidth() < $other->getWidth() => -1,
      $this->getHeight() > $other->getHeight() => 1,
      $this->getHeight() < $other->getHeight() => -1,
      default => 0,
    };
  }

  /**
   * @inheritDoc
   */
  public function greaterThan(CanCompare $other): bool
  {
    return $this->compareTo($other) > 0;
  }

  /**
   * @inheritDoc
   */
  public function greaterThanOrEqual(CanCompare $other): bool
  {
    return $this->compareTo($other) >= 0;
  }

  /**
   * @inheritDoc
   */
  public function lessThan(CanCompare $other): bool
  {
    return $this->compareTo($other) < 0;
  }

  /**
   * @inheritDoc
   */
  public function lessThanOrEqual(CanCompare $other): bool
  {
    return $this->compareTo($other) <= 0;
  }

  /**
   * @inheritDoc
   */
  public function equals(CanEquate $equatable): bool
  {
    if (! $equatable instanceof Grid)
    {
      throw new InvalidArgumentException('The equatable object must be an instance of Grid.');
    }

    return $this->compareTo($equatable) === 0;
  }

  /**
   * @inheritDoc
   */
  public function notEquals(CanEquate $equatable): bool
  {
    return ! $this->equals($equatable);
  }

  /**
   * @inheritDoc
   */
  public function getHash(): string
  {
    return $this->hash;
  }

  /**
   * @inheritDoc
   */
  public function getWidth(): int
  {
    return $this->width;
  }

  /**
   * @inheritDoc
   */
  public function getHeight(): int
  {
    return $this->height;
  }

  /**
   * @inheritDoc
   */
  public function get(int $x, int $y): mixed
  {
    $this->validateCoordinates($x, $y);
    $this->provisionSpace($x, $y);

    return $this->grid[$y][$x];
  }

  /**
   * @inheritDoc
   */
  public function set(int $x, int $y, mixed $value): void
  {
    if ($x < 0)
    {
      throw new InvalidArgumentException("The x coordinate, ($x), must be greater than or equal to 0.");
    }

    if ($y < 0)
    {
      throw new InvalidArgumentException("The y coordinate, ($y), must be greater than or equal to 0.");
    }

    $this->provisionSpace($x, $y);

    $this->grid[$y][$x] = $value;
  }

  /**
   * @inheritDoc
   */
  public function toArray(): array
  {
    return $this->grid;
  }

  /**
   * Validates the coordinates.
   *
   * @param int $x The x-coordinate.
   * @param int $y The y-coordinate.
   * @return void
   */
  private function validateCoordinates(int $x, int $y): void
  {
    if ($x < 0 || $x >= $this->getWidth())
    {
      throw new InvalidArgumentException("The x coordinate, ($x), must be between 0 and the width, $this->width, of the grid.");
    }

    if ($y < 0 || $y >= $this->getHeight())
    {
      throw new InvalidArgumentException("The y coordinate, ($y), must be between 0 and the height, $this->height, of the grid.");
    }
  }

  /**
   * Provisions space in the grid. If the space is not available, it is created.
   *
   * @param int $x The x-coordinate.
   * @param int $y The y-coordinate.
   * @return void
   */
  private function provisionSpace(int $x, int $y): void
  {
    if (! isset($this->grid[$y]) )
    {
      $numberOfRowsToAdd = $y - count($this->grid) + 1;
      $this->grid = array_merge($this->grid, array_fill(0, $numberOfRowsToAdd, array_fill(0, $this->width, $this->initialValue)));
    }

    if (! isset($this->grid[$y][$x]) )
    {
      $numberOfColumnsToAdd = $x - count($this->grid[$y]) + 1;
      $this->grid[$y] = array_merge($this->grid[$y], array_fill(0, $numberOfColumnsToAdd, $this->initialValue));
    }
  }

  /**
   * @inheritDoc
   */
  public function __toString(): string
  {
    return implode("\n", array_map(fn($row) => implode('', $row), $this->grid));
  }

  /**
   * @inheritDoc
   */
  public function fill(int $x, int $y, int $width, int $height, mixed $value): void
  {
    for ($i = $y; $i < $y + $height; $i++)
    {
      for ($j = $x; $j < $x + $width; $j++)
      {
        $this->set($j, $i, $value);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function contains(mixed $value): bool
  {
    foreach ($this->grid as $row)
    {
      if (in_array($value, $row))
      {
        return true;
      }
    }

    return false;
  }
}