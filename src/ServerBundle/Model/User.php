<?php

namespace ServerBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="ServerBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    const ROLE_ADMIN = 1;
    const ROLE_UPLOADER = 2;
    const ROLE_USER = 3;

    static protected $roles = array(
        self::ROLE_ADMIN => 'ROLE_ADMIN',
        self::ROLE_UPLOADER => 'ROLE_UPLOADER',
        self::ROLE_USER => 'ROLE_USER',
    );

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="smallint")
     */
    private $role;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = in_array($role, [static::ROLE_ADMIN, static::ROLE_EDITOR, static::ROLE_MODERATOR]) ? $role : static::ROLE_MODERATOR;
    }

    /**
     * @return array $role
     */
    public function getRoles()
    {
        return array(static::$roles[$this->role]);
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {

    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    public function __toString()
    {
        return $this->getUsername();
    }

}
