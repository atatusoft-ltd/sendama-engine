<?php

namespace Sendama\Engine\Core;

use Sendama\Engine\Core\Component;
use Sendama\Engine\Core\Interfaces\CanAwake;

/**
 * Behaviour class. This class is the base class for all behaviours in the engine.
 */
abstract class Behaviour extends Component
{
  public final function __construct(GameObject $gameObject)
  {
    parent::__construct($gameObject);
  }
}