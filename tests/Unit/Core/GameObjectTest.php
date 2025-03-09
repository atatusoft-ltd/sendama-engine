<?php

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Transform;
use Sendama\Engine\Mocks\MockBehavior;


describe('GameObject', function () {
  beforeEach(function () {
    $this->gameObjectName = 'Test Game Object';
    $this->gameObjectTag = 'Test Tag';

    $this->gameObject = new GameObject($this->gameObjectName);
  });

  it('can be created', function () {
    $gameObject = new GameObject($this->gameObjectName);
    expect(get_class($gameObject))->toEqual(GameObject::class);
  });

  it('can have a name', function () {
    expect($this->gameObject->getName())->toEqual($this->gameObjectName);
  });

  it('can have a tag', function () {
    $gameObject = new GameObject($this->gameObjectName, $this->gameObjectTag);
    expect($gameObject->getTag())->toEqual($this->gameObjectTag);
  });

  it('can have a parent', function () {
    $parent = new GameObject('Parent');
    $this->gameObject->getTransform()->setParent($parent->getTransform());
    expect($this->gameObject->getTransform()->getParent())->toEqual($parent->getTransform());
  });

  it('can have a transform', function () {
    expect($this->gameObject->getTransform())->toBeInstanceOf(Transform::class);
  });

  it('can set and get a component', function () {
    $mockBehaviour = $this->gameObject->addComponent(MockBehavior::class);

    expect($mockBehaviour)
      ->toBeInstanceOf(MockBehavior::class)
      ->and($this->gameObject->getComponent(MockBehavior::class))
      ->toEqual($mockBehaviour);
  });

  it('can set and get multiple components', function () {
    $mockBehaviour1 = $this->gameObject->addComponent(MockBehavior::class);
    $mockBehaviour2 = $this->gameObject->addComponent(MockBehavior::class);

    $gameObject = new GameObject($this->gameObjectName, $this->gameObjectTag);

    $receivedComponent = $gameObject->getComponent(MockBehavior::class);

    expect($mockBehaviour1)
      ->toBeInstanceOf(MockBehavior::class)
      ->and($mockBehaviour2)
      ->toBeInstanceOf(MockBehavior::class)
      ->and($receivedComponent)
      ->toEqual(null)
      ->and($gameObject->getComponentCount())
      ->toBeInt()
      ->toEqual(2)
      ->and($gameObject->getComponentIndex($mockBehaviour2))
      ->toBeInt()
      ->toEqual(-1)
      ->and($this->gameObject->getComponentCount())
      ->toBeInt()
      ->toEqual(4)
      ->and($this->gameObject->getComponentIndex($mockBehaviour2))
      ->toBeInt()
      ->toEqual(3);
  });

  it('can creat a pool of game objects', function () {
    $pool = GameObject::pool($this->gameObject, 10);
    expect($pool)
      ->toBeArray()
      ->toHaveLength(10)
      ->and($pool[0]->getName())
      ->toEqual($this->gameObjectName);
  });

  it('can update all components', function () {
    $mockBehaviour1 = $this->gameObject->addComponent(MockBehavior::class);
    $mockBehaviour2 = $this->gameObject->addComponent(MockBehavior::class);

    $this->gameObject->update();

    expect($mockBehaviour1->updateCount)->toEqual(1);
    expect($mockBehaviour2->updateCount)->toEqual(1);
  });

  it('can broadcast a message to all components', function () {
    $mockBehaviour1 = $this->gameObject->addComponent(MockBehavior::class);
    $mockBehaviour2 = $this->gameObject->addComponent(MockBehavior::class);

    $this->gameObject->broadcast('onUpdate');

    expect($mockBehaviour1->updateCount)->toEqual(1);
    expect($mockBehaviour2->updateCount)->toEqual(1);
  });
});