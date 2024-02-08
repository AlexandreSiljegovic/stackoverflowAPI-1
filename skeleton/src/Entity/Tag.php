<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Question::class, mappedBy: 'question_tag')]
    private Collection $questions;

    #[ORM\ManyToMany(targetEntity: Administrator::class, inversedBy: 'tags')]
    private Collection $administrator_tag;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->administrator_tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->addQuestionTag($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            $question->removeQuestionTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Administrator>
     */
    public function getAdministratorTag(): Collection
    {
        return $this->administrator_tag;
    }

    public function addAdministratorTag(Administrator $administratorTag): static
    {
        if (!$this->administrator_tag->contains($administratorTag)) {
            $this->administrator_tag->add($administratorTag);
        }

        return $this;
    }

    public function removeAdministratorTag(Administrator $administratorTag): static
    {
        $this->administrator_tag->removeElement($administratorTag);

        return $this;
    }
}
