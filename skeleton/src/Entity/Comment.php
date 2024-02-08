<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\ManyToMany(targetEntity: answer::class, inversedBy: 'comments')]
    private Collection $answer_subject_id;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?member $author_id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?question $question_subject_id = null;

    public function __construct()
    {
        $this->answer_subject_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, answer>
     */
    public function getAnswerSubjectId(): Collection
    {
        return $this->answer_subject_id;
    }

    public function addAnswerSubjectId(answer $answerSubjectId): static
    {
        if (!$this->answer_subject_id->contains($answerSubjectId)) {
            $this->answer_subject_id->add($answerSubjectId);
        }

        return $this;
    }

    public function removeAnswerSubjectId(answer $answerSubjectId): static
    {
        $this->answer_subject_id->removeElement($answerSubjectId);

        return $this;
    }

    public function getAuthorId(): ?member
    {
        return $this->author_id;
    }

    public function setAuthorId(?member $author_id): static
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getQuestionSubjectId(): ?question
    {
        return $this->question_subject_id;
    }

    public function setQuestionSubjectId(?question $question_subject_id): static
    {
        $this->question_subject_id = $question_subject_id;

        return $this;
    }
}
