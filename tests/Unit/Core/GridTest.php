<?php

use Sendama\Engine\Core\Grid;

it('Can create a new Grid instance', function () {
    $grid = new Grid();
    expect($grid)->toBeInstanceOf(Grid::class);
});

it('Can get the width and height of the grid', function (int $width, int $height) {
    $grid = new Grid($width, $height);
    expect($grid->getWidth())
      ->toBeInt()
      ->toEqual($width)
      ->and($grid->getHeight())
      ->toBeInt()
      ->toEqual($height);
})->with([
    [10, 10],
    [20, 20],
    [30, 30],
]);

it('Can get and set values in the grid', function (int $x, int $y, int $value) {
    $grid = new Grid();
    $grid->set($x, $y, $value);
    expect($grid->get($x, $y))
      ->toBeInt()
      ->toEqual($value);
})->with([
    [0, 0, 1],
    [1, 1, 2],
    [2, 2, 3],
]);

it('Can get the grid as an array', function () {
    $grid = new Grid(2, 2);
    $grid->set(0, 0, 1);
    $grid->set(1, 1, 2);
    expect($grid->toArray())
      ->toBeArray()
      ->toEqual([
        [1, null],
        [null, 2],
      ]);
});

it('Can get the grid as a string', function () {
    $grid = new Grid(3, 3);
    $grid->set(0, 0, 1);
    $grid->set(1, 1, 2);
    expect((string)$grid)
      ->toBeString()
      ->toEqual("100\n020\n000");
});

it('Can fill the grid with a value', function () {
    $grid = new Grid(2, 2);
    $grid->fill(0, 0, 2, 2, 1);
    expect($grid->toArray())
      ->toBeArray()
      ->toEqual([
        [1, 1],
        [1, 1],
      ]);
});