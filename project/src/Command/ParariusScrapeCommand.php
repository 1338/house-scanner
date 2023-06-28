<?php

namespace App\Command;

use App\Entity\House\Location;
use App\Repository\House\LocationRepository;
use App\Service\API\HouseLocator;
use App\Service\LocationChecker;
use App\Service\Scraper\ParariusScraper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'pararius:scrape',
    description: 'scrape houses from pararius',
)]
class ParariusScrapeCommand extends Command
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


        $pariasScraper = new ParariusScraper();

        $results = $pariasScraper->scrape();

        file_put_contents('pararius.json', json_encode($results));


        $houseLocator = new HouseLocator();

        /** @var LocationRepository $houseLocationRepository */
        $houseLocationRepository = $this->entityManager->getRepository(Location::class);

        foreach ($results as $result) {

        }

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


        //$results = $fundaScraper->scrape('rent', 'appartment', 'heel-nederland', null, 0);


        //$fundaScraper->scrape('rent', 'appartement', null, null);

        //$houseLocator = new HouseLocator();





        return Command::SUCCESS;
    }
}
