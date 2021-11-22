<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @ORM\Table(name="players")
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Assert\NotBlank
     * @Assert\Length(
     *      min=3,
     *      max=16,
     * )
     * @ORM\Column(type="string", length=48)
     */
    private string $firstname;

    /**
     * Assert\NotBlank
     * @Assert\Length(
     *      min=3,
     *      max=16,
     * )
     * @ORM\Column(type="string", length=45)
     */
    private string $lastname;

    /**
     * Assert\NotBlank
     * @Assert\Email
     * @ORM\Column(type="string", length=128)
     */
    private string $email;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private int $mirian;

    /**
     * @Assert\Length(
     *      min=40,
     *      max=40,
     * )
     * @ORM\Column(type="string", length=40)
     */
    private string $identifier;

    /**
     * @Assert\Length(
     *      min=8,
     *      max=60,
     * )
     * @ORM\Column(type="string", length=60)
     */
    private string $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $modification;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $creation;

    /**
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="player")
     */
    private ArrayCollection $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function toArray()
    {
        dump($this);
        return get_object_vars($this);
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMirian(): ?int
    {
        return $this->mirian;
    }

    public function setMirian(int $mirian): self
    {
        $this->mirian = $mirian;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getModification(): ?\DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(\DateTimeInterface $modification): self
    {
        $this->modification = $modification;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setPlayer($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getPlayer() === $this) {
                $character->setPlayer(null);
            }
        }

        return $this;
    }

    public function seriaizerJson($data)
    {
        $encoders = new JsonEncoder();
        $normalizers = new ObjectNormalizer();
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizers], [$encoders]);

        return $serializer->serialize($data, 'json');
    }
}