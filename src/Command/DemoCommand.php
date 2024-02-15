<?php

namespace App\Command;

use App\Repository\TShirtRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:demo',
    description: 'Add a short description for your command',
)]
class DemoCommand extends Command
{
     public const METRIC = [
         'turnover',
         'quantity',
         'avg',
     ];

    public function __construct(
        private readonly TShirtRepository $repository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('metric', InputArgument::OPTIONAL, 'Choose between turnover, quantity or avg sale price', 'turnover')
            ->addOption('by-size', 's', InputOption::VALUE_NONE, 'Group results by t-shirt size')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('metric');
        if (!in_array($arg1, self::METRIC)) {
            $io->error('Choisir entre turnover, quantity ou avg');

            return Command::FAILURE;
        }

        $stat = $this->repository->stat($arg1, $input->hasOption('by-size'));

        $io->info('Les ventes de T-Shirt');

        $table = new Table($output);
        $table->setHeaders(['result', 'size']);
        foreach ($stat as $value) {
            $table->addRow([$value['data'], $value['size']->value]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
