<?php

namespace App\Entity\House;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Municipality;
use App\Entity\Neighbourhood;
use App\Entity\Postcode;
use App\Entity\Road;
use App\Entity\State;
use App\Repository\House\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: House::class, mappedBy: 'location')]
    private $houses;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'locations')]
    private $city;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'locations')]
    private $country;

    #[ORM\ManyToOne(targetEntity: Municipality::class, inversedBy: 'locations')]
    private $municipality;

    #[ORM\ManyToOne(targetEntity: Neighbourhood::class, inversedBy: 'locations')]
    private $neighbourhood;

    #[ORM\ManyToOne(targetEntity: Postcode::class, inversedBy: 'locations')]
    private $postcode;

    #[ORM\ManyToOne(targetEntity: Road::class, inversedBy: 'locations')]
    private $road;

    #[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'locations')]
    private $state;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 8)]
    private $latitude;

    #[ORM\Column(type: 'decimal', precision: 11, scale: 8)]
    private $longitude;

    #[ORM\Column(type: 'decimal', precision: 3, scale: 2, nullable: true)]
    private $importance;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $OSMId;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'locations')]
    private $address;

    public function __construct()
    {
        $this->houses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, House>
     */
    public function getHouses(): Collection
    {
        return $this->houses;
    }

    public function addHouse(House $house): self
    {
        if (!$this->houses->contains($house)) {
            $this->houses[] = $house;
            $house->addLocation($this);
        }

        return $this;
    }

    public function removeHouse(House $house): self
    {
        if ($this->houses->removeElement($house)) {
            $house->removeLocation($this);
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMunicipality(): ?Municipality
    {
        return $this->municipality;
    }

    public function setMunicipality(?Municipality $municipality): self
    {
        $this->municipality = $municipality;

        return $this;
    }

    public function getNeighbourhood(): ?Neighbourhood
    {
        return $this->neighbourhood;
    }

    public function setNeighbourhood(?Neighbourhood $neighbourhood): self
    {
        $this->neighbourhood = $neighbourhood;

        return $this;
    }

    public function getPostcode(): ?Postcode
    {
        return $this->postcode;
    }

    public function setPostcode(?Postcode $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getRoad(): ?Road
    {
        return $this->road;
    }

    public function setRoad(?Road $road): self
    {
        $this->road = $road;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getImportance(): ?string
    {
        return $this->importance;
    }

    public function setImportance(?string $importance): self
    {
        $this->importance = $importance;

        return $this;
    }

    public function getOSMId(): ?int
    {
        return $this->OSMId;
    }

    public function setOSMId(?int $OSMId): self
    {
        $this->OSMId = $OSMId;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
