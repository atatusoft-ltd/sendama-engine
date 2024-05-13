<?php

use Sendama\Engine\UI\Windows\Enumerations\HorizontalAlignment;
use Sendama\Engine\UI\Windows\Enumerations\VerticalAlignment;
use Sendama\Engine\UI\Windows\WindowAlignment;

it('can create an instance of the WindowAlignment class', function() {
  $windowAlignment = new WindowAlignment(
    HorizontalAlignment::CENTER,
    VerticalAlignment::TOP
  );
  expect($windowAlignment)->toBeInstanceOf(WindowAlignment::class);
});

it('can create a top left window alignment', function() {
  $windowAlignment = WindowAlignment::topLeft();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::LEFT)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::TOP);
});

it('can create a top center window alignment', function() {
  $windowAlignment = WindowAlignment::topCenter();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::CENTER)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::TOP);
});

it('can create a top right window alignment', function() {
  $windowAlignment = WindowAlignment::topRight();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::RIGHT)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::TOP);
});

it('can create a middle left window alignment', function() {
  $windowAlignment = WindowAlignment::middleLeft();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::LEFT)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::MIDDLE);
});

it('can create a middle center window alignment', function() {
  $windowAlignment = WindowAlignment::middleCenter();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::CENTER)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::MIDDLE);
});

it('can create a middle right window alignment', function() {
  $windowAlignment = WindowAlignment::middleRight();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::RIGHT)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::MIDDLE);
});

it('can create a bottom left window alignment', function() {
  $windowAlignment = WindowAlignment::bottomLeft();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::LEFT)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::BOTTOM);
});

it('can create a bottom center window alignment', function() {
  $windowAlignment = WindowAlignment::bottomCenter();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::CENTER)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::BOTTOM);
});

it('can create a bottom right window alignment', function() {
  $windowAlignment = WindowAlignment::bottomRight();
  expect($windowAlignment->horizontalAlignment)
    ->toBe(HorizontalAlignment::RIGHT)
    ->and($windowAlignment->verticalAlignment)
    ->toBe(VerticalAlignment::BOTTOM);
});