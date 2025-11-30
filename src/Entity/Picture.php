<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[Vich\Uploadable]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $filename = null;
    
    /**
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
     * @Assert\Image(
     *      mimeTypes = "image/jpeg"
     * )
     * @var File|null
     */
    private ?File $imageFile = null;

    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
    * @param File $imageFile
    * @return self
    */
    public function setImageFile(File $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }
}