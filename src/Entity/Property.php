<?php

namespace App\Entity;

use DateTime;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\All;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[UniqueEntity('title')]
class Property
{
    const HEAT = [
        0 => 'Electrique',
        1 => 'Gaz'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Assert\Length(min: 5, max: 255)]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 10, max: 400)]
    private ?int $surface = null;

    #[ORM\Column(type: 'integer')]
    private ?int $rooms = null;

    #[ORM\Column(type: 'integer')]
    private ?int $bedrooms = null;

    #[ORM\Column(type: 'integer')]
    private ?int $floor = null;

    #[ORM\Column(type: 'integer')]
    private ?int $price = null;

    #[ORM\Column(type: 'integer')]
    private ?int $heat = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $address = null;

    // Postal code field removed as requested

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $sold = false;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\ManyToMany(targetEntity: Preference::class, inversedBy: 'properties')]
    private Collection $preferences;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     *
     * @var Picture|null
     */
    private $picture;  

    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'property', orphanRemoval: true, cascade: ['persist'])]
    private Collection $pictures;

    #[Assert\All([
        new Assert\Image(mimeTypes: ['image/jpeg'])
    ])]
    private $pictureFiles;

    #[ORM\Column(type: 'float', scale: 4, precision: 6)]
    private ?float $lat = null;

    #[ORM\Column(type: 'float', scale: 4, precision: 7)]
    private ?float $lng = null;

    #[ORM\Column(length: 255)]
    private ?string $no = null;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->preferences = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        $slugify = new Slugify();
        return $slugify->slugify($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

     public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function getHeat(): ?int
    {
        return $this->heat;
    }

    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

     public function getHeatType(): string
    {
        return self::HEAT[$this->heat];
    }


    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }


    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Preference[]
     */
    public function getPreferences(): Collection
    {
        return $this->preferences;
    }

    public function addPreference(Preference $preference): self
    {
        if (!$this->preferences->contains($preference)) {
            $this->preferences[] = $preference;
            $preference->addProperty($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): self
    {
        if ($this->preferences->contains($preference)) {
            $this->preferences->removeElement($preference);
            $preference->removeProperty($this);
        }

        return $this;
    }



    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function getPicture(): ?Picture
    {
        /*
        if ($this->pictures->isEmpty()) {
            return null;
        } else{
            return $this->pictures[0];        
        }*/

        return $this->picture;
    }

     public function setPicture($picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProperty($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getProperty() === $this) {
                $picture->setProperty(null);
            }
        }

        return $this;
    }


    /**
     * Get picture files
     * 
     * @return mixed
     */ 
    public function getPictureFiles()
    {
        return $this->pictureFiles;
    }

    /**
     * @param [type] $pictureFiles
     * @return Property
     */ 
    public function setPictureFiles($pictureFiles)
    {
        foreach ($pictureFiles as $pictureFile){
            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->addPicture($picture);
        }
        $this->pictureFiles = $pictureFiles;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): static
    {
        $this->no = $no;

        return $this;
    }
}