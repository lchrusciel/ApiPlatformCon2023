<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-fixtures',
    description: 'Add a short description for your command',
)]
final class LoadFixturesCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $objectManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tShirt = new Product('T-Shirt', 1000);
        $trousers = new Product('Trousers', 5000);

        $order = new Order([
            new OrderItem($tShirt, 2),
            new OrderItem($trousers, 1),
        ]);

        $this->objectManager->persist($tShirt);
        $this->objectManager->persist($trousers);
        $this->objectManager->persist($order);

        $this->objectManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
