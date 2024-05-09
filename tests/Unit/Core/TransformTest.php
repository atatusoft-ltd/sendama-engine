<?php

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Transform;
use Sendama\Engine\Core\Vector2;

$gameObject = new GameObject('Mock Game Object');

it('can create an instance of Transform::class', function (GameObject $gameObject) {
    $transform = new Transform($gameObject);
    expect($transform)->toBeInstanceOf(Sendama\Engine\Core\Transform::class);
})->with([
    'gameObject' => $gameObject
]);

it('can create an instance of Transform::class with a position', function (GameObject $gameObject) {
    $transform = new Transform($gameObject, position: new Vector2(2, 2));
    expect($transform->getPosition())->toBeInstanceOf(Vector2::class)
      ->and($transform->getPosition()->getX())->toBe(2)
      ->and($transform->getPosition()->getY())->toBe(2);
})->with([
    'gameObject' => $gameObject
]);

it('can create an instance of Transform::class with a position and rotation', function (GameObject $gameObject) {
    $transform = new Transform($gameObject, position: new Vector2(2, 2), rotation: new Vector2(90, 0));
    expect($transform->getRotation()->getX())->toBe(90)
      ->and($transform->getRotation()->getY())->toBe(0);
})->with([
    'gameObject' => $gameObject
]);

it('can create an instance of Transform::class with a position, rotation, and scale', function (GameObject $gameObject) {
    $transform = new Transform($gameObject, position: new Vector2(2, 2), scale: new Vector2(2, 2), rotation: new Vector2(90, 0));
    expect($transform->getScale()->getX())->toBe(2)
      ->and($transform->getScale()->getY())->toBe(2);
})->with([
    'gameObject' => $gameObject
]);

it('can create an instance of Transform::class with a position, rotation, scale, and parent', function (GameObject $gameObject) {
    $parent = new GameObject('Parent');
    $transform = new Transform($gameObject, position: new Vector2(2, 2), scale: new Vector2(2, 2), rotation: new Vector2(90, 0), parent: $parent->getTransform());
    expect($transform->getParent())->toBe($parent->getTransform());
})->with([
    'gameObject' => $gameObject
]);

