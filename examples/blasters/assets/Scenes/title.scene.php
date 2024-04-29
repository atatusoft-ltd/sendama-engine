<?php

return [
  'name' => 'Title Scene',
  'namespace' => 'Sendama\Examples\Blasters\Scenes',
  'uses' => [
    'Sendama\Engine\Core\Scenes\AbstractScene'
  ],
  'extends' => 'AbstractScene',
  'game_objects' => [
      [
        'name' => 'Player',
        'components' => [
          [
            'class' => \Sendama\Examples\Blasters\Scripts\PlayerController::class
          ]
        ],
      ],
  ],
];