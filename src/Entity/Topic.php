<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 *
 * @ORM\Table(name="topic")
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubTopic", mappedBy="topic", orphanRemoval=true)
     */
    private $subtopics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="topic", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->subtopics = new ArrayCollection();
        $this->messages = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|SubTopic[]
     */
    public function getSubtopics(): Collection
    {
        return $this->subtopics;
    }

    public function addSubtopic(SubTopic $subtopic): self
    {
        if (!$this->subtopics->contains($subtopic)) {
            $this->subtopics[] = $subtopic;
            $subtopic->setTopic($this);
        }

        return $this;
    }

    public function removeSubtopic(SubTopic $subtopic): self
    {
        if ($this->subtopics->contains($subtopic)) {
            $this->subtopics->removeElement($subtopic);
            // set the owning side to null (unless already changed)
            if ($subtopic->getTopic() === $this) {
                $subtopic->setTopic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setTopic($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getTopic() === $this) {
                $message->setTopic(null);
            }
        }

        return $this;
    }


}
