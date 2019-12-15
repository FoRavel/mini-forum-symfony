<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="user_user_type_FK", columns={"id_user_type"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields = {"username"},
 *  message = "Le nom d'utilisaeur que vous avez spécifié est déjà utilisé"
 * )
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /** 
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tappez le même mot de passe")
     */ 
    public $confirmPassword; 

    /**
     * @var \UserType
     *
     * @ORM\ManyToOne(targetEntity="UserType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_type", referencedColumnName="id")
     * })
     */
    private $idUserType;

    /*
     * @ORM\Column(type="string", length=255, nullable=true)
     * private $picture;
     */
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getIdUserType(): ?UserType
    {
        return $this->idUserType;
    }

    public function setIdUserType(?UserType $idUserType): self
    {
        $this->idUserType = $idUserType;

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    public function getRoles(){
        return ['ROLE_USER'];
    }
    /*
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
*/

}
