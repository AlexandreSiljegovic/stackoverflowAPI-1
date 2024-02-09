<?php

namespace App\entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publication_date = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validated = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    private ?int $views = null;

    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'question_id')]
    private Collection $answers;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'question_subject_id')]
    private Collection $comments;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Member $author_id = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'questions')]
    private Collection $question_tag;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->question_tag = new ArrayCollection();
    }

    // Rest of the code...

}
