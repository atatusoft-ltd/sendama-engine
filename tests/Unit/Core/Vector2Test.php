<?php

use Sendama\Engine\Core\Vector2;

it('can create a new instance of Vector2', function () {
  $vector2 = new Vector2(1, 2);
  expect($vector2)->toBeInstanceOf(Vector2::class);
});

it('can get the string representation of Vector2', function () {
  $vector2 = new Vector2(1, 2);
  expect($vector2->__toString())->toBe('(1, 2)');
});

it('can get a new Vector2(0, 0)', function () {
  $vector2 = Vector2::zero();
  expect($vector2)->toBeInstanceOf(Vector2::class)->and($vector2->__toString())->toBe('(0, 0)');
});

it('can get a new Vector2(1, 1)', function () {
  $vector2 = Vector2::one();
  expect($vector2)->toBeInstanceOf(Vector2::class)->and($vector2->__toString())->toBe('(1, 1)');
});

it('can get a new Vector2(-1, 0)', function () {
  $vector2 = Vector2::left();
  expect($vector2)->toBeInstanceOf(Vector2::class)->and($vector2->__toString())->toBe('(-1, 0)');
});

it('can get a new Vector2(0, -1)', function () {
  $vector2 = Vector2::down();
  expect($vector2)->toBeInstanceOf(Vector2::class)->and($vector2->__toString())->toBe('(0, -1)');
});

it('can get a new Vector2(1, 0)', function () {
  $vector2 = Vector2::right();
  expect($vector2)->toBeInstanceOf(Vector2::class)->and($vector2->__toString())->toBe('(1, 0)');
});

it('can get a new Vector2(0, 1)', function () {
  $vector2 = Vector2::up();
  expect($vector2)->toBeInstanceOf(Vector2::class)->and($vector2->__toString())->toBe('(0, 1)');
});

it('can get the x and y values of Vector2', function () {
  $vector2 = new Vector2(1, 2);
  expect($vector2->getX())->toBe(1)->and($vector2->getY())->toBe(2);
});

it('can set the x and y values of Vector2', function () {
  $vector2 = new Vector2(1, 2);
  $vector2->setX(3);
  $vector2->setY(4);
  expect($vector2->getX())->toBe(3)->and($vector2->getY())->toBe(4);
});

it('can add two Vector2 instances', function () {
  $vector2 = new Vector2(1, 2);
  $vector2->add(new Vector2(3, 4));
  expect($vector2->getX())->toBe(4)->and($vector2->getY())->toBe(6);
});

it('can subtract two Vector2 instances', function () {
  $vector2 = new Vector2(1, 2);
  $vector2->subtract(new Vector2(3, 4));
  expect($vector2->getX())->toBe(-2)->and($vector2->getY())->toBe(-2);
});

it('can multiply two Vector2 instances', function () {
  $result = Vector2::product(new Vector2(1, 2), new Vector2(3, 4));
  expect($result->getX())->toBe(3)->and($result->getY())->toBe(8);
});

it('can divide two Vector2 instances', function () {
  $result = Vector2::quotient(new Vector2(1, 2), new Vector2(3, 4));
  expect($result->getX())->toBe(0)->and($result->getY())->toBe(0);
});

it('can get the magnitude of a Vector2 instance', function () {
  $vector2 = new Vector2(3, 4);
  expect($vector2->getMagnitude())->toBe(5.0);
});

it('can normalize a Vector2 instance', function () {
  $vector2 = new Vector2(3, 4);
  $vector2->normalize();
  expect($vector2->getX())->toBe(0)->and($vector2->getY())->toBe(0);
});

it('can get the distance between two Vector2 instances', function () {
  $a = new Vector2(0, 0);
  $b = new Vector2(6, 8);
  $distance = Vector2::distance($a, $b);
  expect($distance)->toBe(10.0);
});

it('can get the dot product of two Vector2 instances', function () {
  $a = new Vector2(1, 2);
  $b = new Vector2(3, 4);
  $dotProduct = Vector2::dot($a, $b);
  expect($dotProduct)->toBe(11.0);
});

it('can get the sum of two Vector2 instances', function () {
  $a = new Vector2(1, 2);
  $b = new Vector2(3, 4);
  $sum = Vector2::sum($a, $b);
  expect($sum->getX())->toBe(4)->and($sum->getY())->toBe(6);
});

it('can get the difference of two Vector2 instances', function () {
  $a = new Vector2(1, 2);
  $b = new Vector2(3, 4);
  $difference = Vector2::difference($a, $b);
  expect($difference->getX())->toBe(-2)->and($difference->getY())->toBe(-2);
});

it('can get the angle between two Vector2 instances', function () {
  $a = new Vector2(1, 0);
  $b = new Vector2(0, 1);
  $angle = Vector2::angle($a, $b);
  expect($angle)->toBe(90.0);
});

it('can get scale a Vector2 instance', function () {
  $vector2 = new Vector2(1, 2);
  $vector2->scale(2);
  expect($vector2->getX())->toBe(2)->and($vector2->getY())->toBe(4);
});

it('can get the maximum of two Vector2 instances', function () {
  $a = new Vector2(1, 4);
  $b = new Vector2(3, 2);
  $max = Vector2::max($a, $b);
  expect($max->getX())->toBe(3)->and($max->getY())->toBe(4);
});

it('can get the minimum of two Vector2 instances', function () {
  $a = new Vector2(1, 4);
  $b = new Vector2(3, 2);
  $min = Vector2::min($a, $b);
  expect($min->getX())->toBe(1)->and($min->getY())->toBe(2);
});

it('can get the perpendicular of a Vector2 instance', function () {
  $vector2 = new Vector2(1, 2);
  $perpendicular = Vector2::perpendicular($vector2);
  expect($perpendicular->getX())->toBe(-2)->and($perpendicular->getY())->toBe(1);
});

it('it can get the reflection of a Vector2 instance', function () {
  $direction = new Vector2(1, 2);
  $normal = new Vector2(3, 4);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(-5)->and($reflection->getY())->toBe(-4);
});

it('reflects a vector off a vertical surface', function () {
  $direction = new Vector2(3, 4);
  $normal = new Vector2(1, 0);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(-3)->and($reflection->getY())->toBe(4);
});

it('reflects a vector off a horizontal surface', function () {
  $direction = new Vector2(3, 4);
  $normal = new Vector2(0, 1);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(3)->and($reflection->getY())->toBe(-4);
});

it('reflects a vector off a diagonal surface', function () {
  $direction = new Vector2(3, 3);
  $normal = new Vector2(1, 1);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(-9)->and($reflection->getY())->toBe(-9);
});

it('reflects a vector already moving in the direction of the normal', function () {
  $direction = new Vector2(-2, -3);
  $normal = new Vector2(2, 3);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(8)->and($reflection->getY())->toBe(7);
});

it('reflects a vector moving directly toward the normal', function () {
  $direction = new Vector2(5, 0);
  $normal = new Vector2(1, 0);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(-5)->and($reflection->getY())->toBe(0);
});

it('reflects a zero vector and remains zero', function () {
  $direction = new Vector2(0, 0);
  $normal = new Vector2(1, 0);
  $reflection = Vector2::reflect($direction, $normal);
  expect($reflection->getX())->toBe(0)->and($reflection->getY())->toBe(0);
});

