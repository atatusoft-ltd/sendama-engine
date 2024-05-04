<?php

use Sendama\Engine\UI\Windows\BorderPack;
use Sendama\Engine\Util\Path;

require 'vendor/autoload.php';

$width = 40;
$height = 5;

$borderPack = new BorderPack(Path::getAssetsDirectory() . '/border-packs/default.border.php');

echo $borderPack->getTopLeftCorner();

for ($x = 1; $x < $width - 1; $x++)
{
  echo $borderPack->getHorizontalBorder();
}

echo $borderPack->getTopRightCorner() . PHP_EOL;

for ($y = 1; $y < $height - 1; $y++)
{
  echo $borderPack->getVerticalBorder();

  for ($x = 1; $x < $width - 1; $x++)
  {
    echo ' ';
  }

  echo $borderPack->getVerticalBorder() . PHP_EOL;
}

echo $borderPack->getBottomLeftCorner();

for ($x = 1; $x < $width - 1; $x++)
{
  echo $borderPack->getHorizontalBorder();
}

echo $borderPack->getBottomRightCorner() . PHP_EOL;