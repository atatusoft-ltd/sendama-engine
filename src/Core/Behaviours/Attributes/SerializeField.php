<?php

namespace Sendama\Engine\Core\Behaviours\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class SerializeField
{
  /**
   * @param string|null $name
   */
  public function __construct(public ?string $name = null)
  {
  }
}