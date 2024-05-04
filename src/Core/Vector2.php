<?php

namespace Sendama\Engine\Core;

use Sendama\Engine\Core\Interfaces\CanEquate;
use Stringable;

class Vector2 implements CanEquate, Stringable
{
  /**
   * Vector2 constructor.
   *
   * @param int $x The x coordinate.
   * @param int $y The y coordinate.
   */
  public function __construct(
    protected int $x = 0,
    protected int $y = 0
  )
  {
  }

  /**
   * Gets the string representation of this vector.
   *
   * @return string The string representation of this vector.
   */
  public function __toString(): string
  {
    return "Vector2($this->x, $this->y)";
  }

  /**
   * Shortcut for Vector2(0, 0).
   *
   * @return Vector2 Returns a new Vector2(0, 0).
   */
  public static function zero(): Vector2
  {
    return new Vector2(0, 0);
  }

  /**
   * Shortcut for Vector2(1, 1).
   *
   * @return Vector2 Returns a new Vector2(1, 1).
   */
  public static function one(): Vector2
  {
    return new Vector2(1, 1);
  }

  /**
   * Shortcut for Vector2(-1, 0).
   *
   * @return Vector2 Returns a new Vector2(-1, 0).
   */
  public static function left(): Vector2
  {
    return new Vector2(-1, 0);
  }

  /**
   * Shortcut for Vector2(1, 0).
   *
   * @return Vector2 Returns a new Vector2(1, 0).
   */
  public static function right(): Vector2
  {
    return new Vector2(1, 0);
  }

  /**
   * Shortcut for Vector2(0, 1).
   *
   * @return Vector2 Returns a new Vector2(0, 1).
   */
  public static function up(): Vector2
  {
    return new Vector2(0, 1);
  }

  /**
   * Shortcut for Vector2(0, -1).
   *
   * @return Vector2 Returns a new Vector2(0, -1).
   */
  public static function down(): Vector2
  {
    return new Vector2(0, -1);
  }

  /* Getters and Setters */
  /**
   * Gets the x coordinate.
   *
   * @return int
   */
  public function getX(): int
  {
    return $this->x;
  }

  /**
   * Gets the y coordinate.
   *
   * @return int
   */
  public function getY(): int
  {
    return $this->y;
  }

  /**
   * Sets the x coordinate.
   *
   * @param int $x The x coordinate.
   * @return Vector2
   */
  public function setX(int $x): self
  {
    $this->x = $x;

    return $this;
  }

  /**
   * Sets the y coordinate.
   *
   * @param int $y The y coordinate.
   * @return Vector2
   */
  public function setY(int $y): self
  {
    $this->y = $y;

    return $this;
  }

  /**
   * Returns the length of this vector.
   *
   * @return float
   */
  public function getMagnitude(): float
  {
    return sqrt($this->getSquareMagnitude());
  }

  /**
   * Gets the square magnitude of this vector.
   *
   * @return float The square magnitude of this vector.
   */
  public function getSquareMagnitude(): float
  {
    return $this->x * $this->x + $this->y * $this->y;
  }

  /**
   * Returns a new vector that is the normalized version of this vector.
   *
   * @return Vector2 The normalized vector.
   */
  public function getNormalized(): Vector2
  {
    $length = $this->getMagnitude();

    if (abs($length) > PHP_FLOAT_MIN)
    {
      return new Vector2($this->x / $length, $this->y / $length);
    }

    return new Vector2();
  }

  public function normalize(): void
  {
    $length = $this->getMagnitude();

    if (abs($length) > PHP_FLOAT_MIN)
    {
      $this->x /= $length;
      $this->y /= $length;
    }
  }

  /* Static methods */
  /**
   * Gets a clone of the given vector.
   *
   * @param Vector2 $original The original vector.
   * @return self The clone.
   */
  public static function getClone(Vector2 $original): self
  {
    return new Vector2($original->getX(), $original->getY());
  }

  /**
   * Calculates the sum of the given vectors. The first vector is the augend, the rest are the addends.
   *
   * @param Vector2 ...$vectors
   * @return self This vector.
   */
  public static function sum(Vector2 ...$vectors): self
  {
    $result = new Vector2();

    foreach ($vectors as $vector)
    {
      $result->add($vector);
    }

    return $result;
  }

  /**
   * Calculates the difference of the given vectors. The first vector is the minuend, the rest are the subtrahends.
   *
   * @param Vector2 ...$vectors The vectors to subtract.
   * @return self The difference.
   */
  public static function difference(Vector2 ...$vectors): self
  {
    $result = new Vector2();

    foreach ($vectors as $vector)
    {
      $result->subtract($vector);
    }

    return $result;
  }

  /**
   * Calculates the product of the given vectors. The first vector is the multiplicand, the rest are the multipliers.
   *
   * @param Vector2 ...$vectors The vectors to multiply.
   * @return self The product.
   */
  public static function product(Vector2 ...$vectors): self
  {
    $result = new Vector2();

    foreach ($vectors as $vector)
    {
      $result->multiply($vector);
    }

    return $result;
  }

  /**
   * Calculates the quotient of the given vectors. The first vector is the dividend, the rest are the divisors.
   *
   * @param Vector2 ...$vectors The vectors to divide.
   * @return self The quotient.
   */
  public static function quotient(Vector2 ...$vectors): self
  {
    $result = new Vector2();

    foreach ($vectors as $vector)
    {
      $result->divide($vector);
    }

    return $result;
  }

  /**
   * Calculates the distance between two vectors. It is the same as ($a - $b).getMagnitude().
   *
   * @param Vector2 $a The first vector.
   * @param Vector2 $b The second vector.
   * @return float The distance between the two vectors.
   */
  public static function distance(Vector2 $a, Vector2 $b): float
  {
    return Vector2::difference($a, $b)->getMagnitude();
  }

  /* Operator methods */
  /**
   * Adds the given vector to this vector.
   *
   * @param Vector2 $other The vector to add.
   * @return void
   */
  public function add(Vector2 $other): void
  {
    $this->setX($this->getX() + $other->getX());
    $this->setY($this->getY() + $other->getY());
  }

  /**
   * Subtracts the given vector from this vector.
   *
   * @param Vector2 $other The vector to subtract.
   * @return void
   */
  public function subtract(Vector2 $other): void
  {
    $this->setX($this->getX() - $other->getX());
    $this->setY($this->getY() - $other->getY());
  }

  /**
   * Multiplies the given vector with this vector.
   *
   * @param Vector2 $other The vector to multiply.
   * @return void
   */
  public function multiply(Vector2 $other): void
  {
    $this->setX($this->getX() * $other->getX());
    $this->setY($this->getY() * $other->getY());
  }

  /**
   * Divides the given vector with this vector.
   *
   * @param Vector2 $other The vector to divide.
   * @return void
   */
  public function divide(Vector2 $other): void
  {
    $this->setX($this->getX() / $other->getX());
    $this->setY($this->getY() / $other->getY());
  }

  /**
   * Returns true if the given equatable is equal to this equatable.
   *
   * @param CanEquate $equatable The equatable to compare.
   * @return bool True if the given equatable is equal to this equatable.
   */
  public function equals(CanEquate $equatable): bool
  {
    return $this->getHash() === $equatable->getHash();
  }

  /**
   * Returns true if the given equatable is not equal to this equatable.
   *
   * @param CanEquate $equatable The equatable to compare.
   * @return bool True if the given equatable is not equal to this equatable.
   */
  public function notEquals(CanEquate $equatable): bool
  {
    return !$this->equals($equatable);
  }

  /**
   * Gets the hash of this equatable.
   *
   * @return string The hash of this equatable.
   */
  public function getHash(): string
  {
    return uniqid(md5(__CLASS__) . '.' . md5($this->x . '.' . $this->y));
  }

  /**
   * Linearly interpolates between two vectors.
   *
   * @param Vector2 $a The first vector.
   * @param Vector2 $b The second vector.
   * @param float $t The interpolation value. Should be between 0 and 1.
   *
   * @return Vector2 The interpolated vector.
   */
  public function lerp(Vector2 $a, Vector2 $b, float $t): Vector2
  {
    $t = clamp($t, 0, 1);

    $x = lerp($a->getX(), $b->getX(), $t);
    $y = lerp($a->getY(), $b->getY(), $t);

    return new Vector2($x, $y);
  }
}