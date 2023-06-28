<?php

namespace App\Command;

use App\Entity\House\Location;
use App\Repository\House\LocationRepository;
use App\Service\API\HouseLocator;
use App\Service\LocationChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'test',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private LocationChecker $locationChecker;

    /**
     * @param EntityManagerInterface $entityManager
     * @param LocationChecker $locationChecker
     */
    public function __construct(EntityManagerInterface $entityManager, LocationChecker $locationChecker)
    {
        $this->entityManager = $entityManager;
        $this->locationChecker = $locationChecker;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $houseLocator = new HouseLocator();

        /** @var LocationRepository $houseLocationRepository */
        $houseLocationRepository = $this->entityManager->getRepository(Location::class);

        $houseLocationData = $houseLocator->locate('Willemskade', '40b', '8911BC', 'Leeuwarden');

        if($houseLocationData) {
            $houseLocation = $houseLocationRepository->findOneBy([
                'longitude' => $houseLocationData['lon'],
                'latitude' => $houseLocationData['lat']
            ]);

            if(!$houseLocation) {
                $this->locationChecker->createIfNotExistsCheck($houseLocationData);
                // time to make a new house location
            }
        }





        //dump($houseLocator->locate('Zuidvliet', '281', '8921ET', 'Leeuwarden'));
        //dump($houseLocator->locate('Zuidvliet', '284', '8921ET', 'Leeuwarden'));

        return Command::SUCCESS;
    }
}
