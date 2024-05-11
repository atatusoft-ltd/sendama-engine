<?php

use Sendama\Engine\IO\Enumerations\Color;
use Sendama\Engine\UI\Windows\Enumerations\HorizontalAlignment;
use Sendama\Engine\UI\Windows\Enumerations\VerticalAlignment;
use Sendama\Engine\UI\Windows\Window;
use Sendama\Engine\UI\Windows\WindowAlignment;

it('can create an instance of the Window class', function () {
    $window = new Window();
    expect($window)->toBeInstanceOf(Window::class);
});

it('can set the title of the window', function () {
    $window = new Window();
    $window->setTitle('Test Window');
    expect($window->getTitle())->toBe('Test Window');
});

it('can set the help message of the window', function () {
    $window = new Window();
    $window->setHelp('This is a test window.');
    expect($window->getHelp())->toBe('This is a test window.');
});

it('can set the alignment of the window', function () {
    $window = new Window();
    $window->setAlignment(WindowAlignment::topCenter());
    expect($window->getAlignment()->horizontalAlignment)
      ->toBe(HorizontalAlignment::CENTER)
      ->and($window->getAlignment()->verticalAlignment)
      ->toBe(VerticalAlignment::TOP);
});

it('can set the background color of the window', function () {
    $window = new Window();
    $window->setBackgroundColor(Color::RED);
    expect($window->getBackgroundColor())->toBe(Color::RED);
});

it('can set the foreground color of the window', function () {
    $window = new Window();
    $window->setForegroundColor(Color::RED);
    expect($window->getForegroundColor())->toBe(Color::RED);
});

it('can set the content of the window', function (array $content) {
  $window = new Window();
  $window->setContent($content);
  expect($window->getContent())->toEqual($content);
})->with([
  fn() => [
    'This is a test content.',
    'This is the second line of test content'
  ],
  fn() => [
    'This is another test content.'
  ]
]);