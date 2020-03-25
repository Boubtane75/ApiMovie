<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="events")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="message")
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $evenement;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatat(): ?\DateTimeInterface
    {
        return $this->creatat;
    }

    public function setCreatat(\DateTimeInterface $creatat): self
    {
        $this->creatat = $creatat;

        return $this;
    }

    public function getEvent(): ?Utilisateur
    {
        return $this->user;
    }

    public function setEvent(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function getEvenement(): ?string
    {
        return $this->evenement;
    }

    public function setEvenement(string $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
    public function __toString()
    {
        return $this->evenement;
    }
}
