<?php

namespace App\Entity;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function isValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(?bool $validated): static
    {
        $this->validated = $validated;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): static
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestionId($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestionId() === $this) {
                $answer->setQuestionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setQuestionSubjectId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getQuestionSubjectId() === $this) {
                $comment->setQuestionSubjectId(null);
            }
        }

        return $this;
    }

    public function getAuthorId(): ?Member
    {
        return $this->author_id;
    }

    public function setAuthorId(?Member $author_id): static
    {
        $this->author_id = $author_id;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getQuestionTag(): Collection
    {
        return $this->question_tag;
    }

    public function addQuestionTag(Tag $questionTag): static
    {
        if (!$this->question_tag->contains($questionTag)) {
            $this->question_tag->add($questionTag);
        }

        return $this;
    }

    public function removeQuestionTag(Tag $questionTag): static
    {
        $this->question_tag->removeElement($questionTag);

        return $this;
    }
}
