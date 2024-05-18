<?php

namespace Sendama\Engine\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class Header
{
  /**
   * Header constructor.
   * @param string $text
   */
  public function __construct(public string $text)
  {
  }
}