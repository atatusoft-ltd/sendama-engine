<?php

use Sendama\Engine\UI\Windows\WindowPadding;

it('can create an instance of the WindowPadding class', function() {
  $windowPadding = new WindowPadding();
  expect($windowPadding)->toBeInstanceOf(WindowPadding::class);
});

it('can set the top padding of the window', function() {
  $windowPadding = new WindowPadding();
  $windowPadding->setTopPadding(1);
  expect($windowPadding->getTopPadding())->toBe(1);
});

it('can set the right padding of the window', function() {
  $windowPadding = new WindowPadding();
  $windowPadding->setRightPadding(1);
  expect($windowPadding->getRightPadding())->toBe(1);
});

it('can set the bottom padding of the window', function() {
  $windowPadding = new WindowPadding();
  $windowPadding->setBottomPadding(1);
  expect($windowPadding->getBottomPadding())->toBe(1);
});

it('can set the left padding of the window', function() {
  $windowPadding = new WindowPadding();
  $windowPadding->setLeftPadding(1);
  expect($windowPadding->getLeftPadding())->toBe(1);
});