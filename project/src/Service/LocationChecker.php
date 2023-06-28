<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Municipality;
use App\Entity\Neighbourhood;
use App\Entity\Postcode;
use App\Entity\Road;
use App\Entity\State;
use App\Repository\AddressRepository;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\MunicipalityRepository;
use App\Repository\NeighbourhoodRepository;
use App\Repository\PostcodeRepository;
use App\Repository\RoadRepository;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;

class LocationChecker
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function check(array $locationData): bool
    {

        return true;
    }

    public function createIfNotExistsCheck(array $locationData)
    {
        $shouldFlush = false;

        if ($locationData['address']['house_number']) {
            $addressFound = $this->checkAddress($locationData['address']['house_number']);
            if (!$addressFound) {
                $address = new Address();
                $address->setName($locationData['address']['house_number']);
                $this->entityManager->persist($address);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['road']) {
            $roadFound = $this->checkRoad($locationData['address']['road']);
            if (!$roadFound) {
                $road = new Road();
                $road->setName($locationData['address']['road']);
                $this->entityManager->persist($road);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['city']) {
            $cityFound = $this->checkCity($locationData['address']['city']);
            if (!$cityFound) {
                $city = new City();
                $city->setName($locationData['address']['city']);
                $this->entityManager->persist($city);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['state']) {
            $stateFound = $this->checkState($locationData['address']['state']);
            if (!$stateFound) {
                $state = new State();
                $state->setName($locationData['address']['state']);
                $this->entityManager->persist($state);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['country']) {
            $countryFound = $this->checkCountry($locationData['address']['country'], $locationData['address']['country_code']);
            if (!$countryFound) {
                $country = new Country();
                $country->setName($locationData['address']['country']);
                $country->setCountryCode($locationData['address']['country_code']);
                $this->entityManager->persist($country);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['municipality']) {
            $municipalityFound = $this->checkMunicipality($locationData['address']['municipality']);
            if (!$municipalityFound) {
                $municipality = new Municipality();
                $municipality->setName($locationData['address']['municipality']);
                $this->entityManager->persist($municipality);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['neighbourhood']) {
            $neighbourhoodFound = $this->checkNeighbourhood($locationData['address']['neighbourhood']);
            if (!$neighbourhoodFound) {
                $neighbourhood = new Neighbourhood();
                $neighbourhood->setName($locationData['address']['neighbourhood']);
                $this->entityManager->persist($neighbourhood);

                $shouldFlush = true;
            }
        }

        if($locationData['address']['postcode']) {
            $postcodeFound = $this->checkPostcode($locationData['address']['postcode']);
            if (!$postcodeFound) {
                $postcode = new Postcode();
                $postcode->setName($locationData['address']['postcode']);
                $this->entityManager->persist($postcode);

                $shouldFlush = true;
            }
        }

        if ($shouldFlush) {
            $this->entityManager->flush();
        }
    }


    private function checkAddress(string $address): Address|null
    {
        /** @var AddressRepository $addressRepository */
        $addressRepository = $this->entityManager->getRepository(Address::class);

        return $addressRepository->findOneBy([
            'name' => $address
        ]);
    }

    private function checkRoad(string $road): Road|null
    {
        /** @var RoadRepository $roadRepository */
        $roadRepository = $this->entityManager->getRepository(Road::class);

        return $roadRepository->findOneBy([
            'name' => $road
        ]);
    }

    private function checkNeighbourhood(string $neighbourhood): Neighbourhood|null
    {
        /** @var NeighbourhoodRepository $neighbourhoodRepository */
        $neighbourhoodRepository = $this->entityManager->getRepository(Neighbourhood::class);

        return $neighbourhoodRepository->findOneBy([
            'name' => $neighbourhood
        ]);
    }

    private function checkMunicipality(string $municipality): Municipality|null
    {
        /** @var MunicipalityRepository $municipalityRepository */
        $municipalityRepository = $this->entityManager->getRepository(Municipality::class);

        return $municipalityRepository->findOneBy([
            'name' => $municipality
        ]);
    }

    private function checkCity(string $city): City|null
    {
        /** @var CityRepository $cityRepository */
        $cityRepository = $this->entityManager->getRepository(City::class);

        return $cityRepository->findOneBy([
            'name' => $city
        ]);
    }

    private function checkState(string $state): State|null
    {
        /** @var StateRepository $stateRepository */
        $stateRepository = $this->entityManager->getRepository(State::class);

        return $stateRepository->findOneBy([
            'name' => $state
        ]);
    }

    private function checkCountry(string $countryName, string $countryCode): Country|null
    {
        /** @var CountryRepository $countryRepository */
        $countryRepository = $this->entityManager->getRepository(Country::class);

        return $countryRepository->findOneBy([
            'name' => $countryName,
            'countryCode' => $countryCode
        ]);
    }

    private function checkPostcode(string $postcode): Postcode|null
    {
        /** @var PostcodeRepository $postcodeRepository */
        $postcodeRepository = $this->entityManager->getRepository(Postcode::class);

        return $postcodeRepository->findOneBy([
            'name' => $postcode
        ]);
    }
}