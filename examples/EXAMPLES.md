# Sendama Engine &mdash; Example Games

## Table of Contents

- [Introduction](#introduction)
- [Games](#games)
  - [Blasters](#blasters)
  - [The Collector](#the-collector)
  - [Snake](#snake)
  - [Pong](#pong)

## Introduction
The examples in this directory are made to demonstrate how Sendama may be used to make simple 2D games.

## Games

### Blasters
A simple game where you control a spaceship and shoot at asteroids.

![Blasters Demo](blasters/blasters.gif)

#### Controls
- `W` or `Up Arrow` to move up
- `A` or `Left Arrow` to move left
- `S` or `Down Arrow` to move down
- `D` or `Right Arrow` to move right
- `Q` to quit the game
- `R` to restart the game
- `Esc` to pause/resume the game
- `Space` to shoot

#### Objective
Destroy all the asteroids to win.

![The Collector Demo](collector/collector.gif)

#### Notes
- The player cannot move through walls.
- The player can shoot at asteroids to destroy them.
- The player wins when all asteroids are destroyed.
- The player loses if the spaceship collides with an asteroid.

### The Collector
A simple game where you control a player and try to collect all the coins.

#### Controls
- `W` or `Up Arrow` to move up
- `A` or `Left Arrow` to move left
- `S` or `Down Arrow` to move down
- `D` or `Right Arrow` to move right
- `Q` to quit the game
- `R` to restart the game
- `Esc` to pause/resume the game
- `Space` to perform an action (e.g. open doors, chests, etc.)

#### Objective
Collect all the coins to win.

#### Notes
- The player cannot move through walls.
- Each coin collected increases the player's score by 1.
- The player wins when all coins are collected.

### Snake
A simple game where you control a snake and try to eat the food.

![Snake Demo](snake/snake.gif)

#### Controls
- `W` or `Up Arrow` to move up
- `A` or `Left Arrow` to move left
- `S` or `Down Arrow` to move down
- `D` or `Right Arrow` to move right
- `Q` to quit the game
- `R` to restart the game
- `Esc` to pause/resume the game

#### Objective
Eat the food to grow the snake.

#### Notes
- The player loses if the snake collides with the walls or itself.
- The player wins when the snake fills the entire screen.
- The snake grows by 1 unit each time it eats the food.
- The food is randomly placed on the screen each time it is eaten.

### Pong
A simple game where you control a paddle and try to hit the ball past your opponent.

![Pong Demo](pong/pong.gif)

#### Controls
- `W` or `Up Arrow` to move the paddle up
- `S` or `Down Arrow` to move the paddle down
- `Q` to quit the game
- `R` to restart the game
- `Esc` to pause/resume the game
- `Space` to serve the ball
- `P` to toggle the AI opponent
- `1` to set the AI difficulty to easy
- `2` to set the AI difficulty to medium
- `3` to set the AI difficulty to hard
- `4` to set the AI difficulty to impossible

#### Objective
Score more points than your opponent to win.

#### Notes
- The player wins if the ball passes the opponent's paddle.
- The player loses if the ball passes their own paddle.
- The ball speeds up each time it hits a paddle.
- The AI opponent will try to hit the ball back to the player.
- The AI difficulty can be adjusted to make the opponent easier or harder to beat.
- The game ends when one player reaches the score limit.
- The score limit can be adjusted in the game settings.