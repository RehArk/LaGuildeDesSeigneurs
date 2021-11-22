<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="characters")
 */
class Character
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id = 1;

    /**
     * Assert\NotBlank
     * @Assert\Length(
     *      min=3,
     *      max=16,
     * )
     * @ORM\Column(type="string", length=16)
     * 
     */
    private string $kind;

    /**
     * Assert\NotBlank
     * @Assert\Length(
     *      min=3,
     *      max=16,
     * )
     * @ORM\Column(type="string", length=16)
     */
    private string $name;

    /**
     * Assert\NotBlank
     * @Assert\Length(
     *      min=3,
     *      max=64,
     * )
     * @ORM\Column(type="string", length=64)
     */
    private string $surname;

    /**
     * @Assert\Length(
     *      min=3,
     *      max=16,
     * )
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private string $caste;

    /**
     * @Assert\Length(
     *      min=3,
     *      max=16,
     * )
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private string $knowledge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $intelligence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $life;

    /**
     * @Assert\Length(
     *      min=5,
     *      max=128,
     * )
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private string $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $creation;

    /**
     * @Assert\Length(
     *      min=40,
     *      max=40,
     * )
     * @ORM\Column(type="string", length=40)
     */
    private string $identifier;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $modification;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="characters")
     */
    private Player $player;

    /**
     * Converts the entity in a array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCaste(): ?string
    {
        return $this->caste;
    }

    public function setCaste(?string $caste): self
    {
        $this->caste = $caste;

        return $this;
    }

    public function getKnowledge(): ?string
    {
        return $this->knowledge;
    }

    public function setKnowledge(?string $knowledge): self
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(?int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(?int $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function setKind(string $kind): self
    {
        $this->kind = $kind;

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

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

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

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
