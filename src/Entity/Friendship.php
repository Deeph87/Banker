<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRepository")
 */
class Friendship
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friendships", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $me;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friendsIveAsked", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMe(): ?User
    {
        return $this->me;
    }

    public function setMe(?User $me): self
    {
        $this->me = $me;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFriend(): ?User
    {
        return $this->friend;
    }

    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

    public function __toString(): string {
        return $this->friend->getPseudo() . " (" . $this->friend->getFirstname() . " " . $this->friend->getLastname() . ")";
    }
}
