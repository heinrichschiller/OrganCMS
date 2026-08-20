<?php

declare(strict_types=1);

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

final class AboutCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();

        $this->setName('about');
        $this->setDescription('Environment.......................................');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = 'Composer';
        $version = '7.3.2';

        $terminalWidth = (new Terminal())->getWidth();

        $line = $this->formatDotLine($name, $version, $terminalWidth);

        $output->writeln('<info>Environment.......................................................</info>');
        $output->writeln(sprintf('PHP Version................................................. %s', phpversion()));
        $output->writeln(sprintf('Composer.................................................... %s', $this->getComposerVersion()));
        $output->writeln($line);

        return Command::SUCCESS;
    }

    private function formatDotLine(string $left, string $right, int $width): string
    {
        $left = ltrim($left);
        $right = rtrim($right);

        $dots = max(1, ($width - 1) - strlen($left) - strlen($right));

        return sprintf("%s%s %s", $left, str_repeat('.', $dots), $right);
    }

    protected function getComposerVersion(): string
    {
        $version = trim(shell_exec('composer --version | grep -oE "[0-9]+\.[0-9]+\.[0-9]+"'));

        return $version;
    }
}
