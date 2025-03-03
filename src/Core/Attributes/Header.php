<?php

namespace Sendama\Engine\Core\Attributes;

use Attribute;

/**
 * Class Header. Used to display a header in the inspector.
 *
 * @package Sendama\Engine\Core\Attributes
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class Header
{
  /**
   * Header constructor. Creates a new header.
   *
   * @param string $text
   */
  public function __construct(public string $text)
  {
  }
}