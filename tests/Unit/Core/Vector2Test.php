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
    expect($vector2)->toBeInstanceOf(Vector2::class)
      ->and($vector2->__toString())->toBe('(0, 0)');
});

it('can get a new Vector2(1, 1)', function () {
    $vector2 = Vector2::one();
    expect($vector2)->toBeInstanceOf(Vector2::class)
      ->and($vector2->__toString())->toBe('(1, 1)');
});

it('can get a new Vector2(-1, 0)', function () {
    $vector2 = Vector2::left();
    expect($vector2)->toBeInstanceOf(Vector2::class)
      ->and($vector2->__toString())->toBe('(-1, 0)');
});

it('can get a new Vector2(0, -1)', function () {
    $vector2 = Vector2::down();
    expect($vector2)->toBeInstanceOf(Vector2::class)
      ->and($vector2->__toString())->toBe('(0, -1)');
});

it('can get a new Vector2(1, 0)', function () {
    $vector2 = Vector2::right();
    expect($vector2)->toBeInstanceOf(Vector2::class)
      ->and($vector2->__toString())->toBe('(1, 0)');
});

it('can get a new Vector2(0, 1)', function () {
    $vector2 = Vector2::up();
    expect($vector2)->toBeInstanceOf(Vector2::class)
      ->and($vector2->__toString())->toBe('(0, 1)');
});

it('can get the x and y values of Vector2', function () {
    $vector2 = new Vector2(1, 2);
    expect($vector2->getX())->toBe(1)
      ->and($vector2->getY())->toBe(2);
});

it('can set the x and y values of Vector2', function () {
    $vector2 = new Vector2(1, 2);
    $vector2->setX(3);
    $vector2->setY(4);
    expect($vector2->getX())->toBe(3)
      ->and($vector2->getY())->toBe(4);
});

it('can add two Vector2 instances', function () {
    $vector2 = new Vector2(1, 2);
    $vector2->add(new Vector2(3, 4));
    expect($vector2->getX())->toBe(4)
      ->and($vector2->getY())->toBe(6);
});

it('can subtract two Vector2 instances', function () {
    $vector2 = new Vector2(1, 2);
    $vector2->subtract(new Vector2(3, 4));
    expect($vector2->getX())->toBe(-2)
      ->and($vector2->getY())->toBe(-2);
});

it('can multiply two Vector2 instances', function () {
    $vector2 = new Vector2(1, 2);
    $vector2->multiply(new Vector2(3, 4));
    expect($vector2->getX())->toBe(3)
      ->and($vector2->getY())->toBe(8);
});

it('can divide two Vector2 instances', function () {
    $vector2 = new Vector2(1, 2);
    $vector2->divide(new Vector2(3, 4));
    expect($vector2->getX())->toBe(0)
      ->and($vector2->getY())->toBe(0);
});

it('can get the magnitude of a Vector2 instance', function () {
    $vector2 = new Vector2(3, 4);
    expect($vector2->getMagnitude())->toBe(5.0);
});

it('can normalize a Vector2 instance', function () {
    $vector2 = new Vector2(3, 4);
    $vector2->normalize();
    expect($vector2->getX())->toBe(0)
      ->and($vector2->getY())->toBe(0);
});

it('can get the distance between two Vector2 instances', function () {
    $a = new Vector2(0, 0);
    $b = new Vector2(6, 8);
    $distance = Vector2::distance($a, $b);
    expect($distance)->toBe(10.0);
});

