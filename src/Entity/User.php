<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;



    /**
     * @ORM\Column(name="user_role",type="string", length=150, nullable=true)
     */
    private $userrole;

    /**
     * @return mixed
     */
    public function getUserrole()
    {
        return $this->userrole;
    }

    /**
     * @param mixed $userrole
     * @return User
     */
    public function setUserrole($userrole)
    {
        $this->userrole = $userrole;
        return $this;
    }





    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="users")
     */
    private $tasks;






    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ToDoRole", mappedBy="users")
     */
    private $todoRoles;





    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->todoRoles = new ArrayCollection();
    }





    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles=$this->todoRoles->map(function ($todoRoles) {

            return $todoRoles->getTitle();
        }
        )->toArray();

        $roles[]= 'ROLE_USER';

        return $roles;

    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUsers($this);
        }

        return $this;
    }

    public function removeTask(Task $task)
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getUsers() === $this) {
                $task->setUsers(null);
            }
        }

        return $this;
    }




    /**
     * @return Collection|ToDoRole[]
     */
    public function gettodoRoles(): Collection
    {
        return $this->todoRoles;
    }

    public function addtodoRole(ToDoRole $todoRole): self
    {
        if (!$this->todoRoles->contains($todoRole)) {
            $this->todoRoles[] = $todoRole;
            $todoRole->adduser($this);
        }

        return $this;
    }

    public function removetodoRole(ToDoRole $todoRole): self
    {
        if ($this->todoRoles->contains($todoRole)) {
            $this->todoRoles->removeElement($todoRole);
            $todoRole->removeuser($this);
        }

        return $this;
    }
}
