<?php

namespace Sendama\Engine\CLI\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'create:game',
  description: 'Creates a new game project.',
  aliases: ['create-game'],
  hidden: false
)]
class CreateGameCommand extends Command
{
  public function execute(InputInterface $input, OutputInterface $output): int
  {

    return Command::SUCCESS;
  }
}