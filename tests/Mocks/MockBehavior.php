<?php

namespace Sendama\Engine\Mocks;

use Sendama\Engine\Core\Behaviours\Behaviour;

class MockBehavior extends Behaviour
{
  public int $startCount = 0;
  public int $updateCount = 0;
  public int $fixedUpdateCount = 0;
  public int $suspendCount = 0;
  public int $resumeCount = 0;

  public function onStart(): void
  {
    $this->startCount++;
  }

  public function onUpdate(): void
  {
    $this->updateCount++;
  }

  public function onFixedUpdate(): void
  {
    $this->fixedUpdateCount++;
  }

  public function onSuspend(): void
  {
    $this->suspendCount++;
  }

  public function onResume(): void
  {
    $this->resumeCount++;
  }
}