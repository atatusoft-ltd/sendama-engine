<?php

namespace Sendama\Engine\Core\Behaviours\Attributes;

use Attribute;

/**
 * The serialize field attribute. This attribute is used to mark a property as serializable.
 *
 * @package Sendama\Engine\Core\Behaviours\Attributes
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class SerializeField
{
  /**
   * SerializeField constructor.
   *
   * @param string|null $name The name of the serialized field.
   */
  public function __construct(public ?string $name = null)
  {
  }
}