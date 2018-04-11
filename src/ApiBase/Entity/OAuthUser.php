<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:16:39
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:45:57
 */

namespace ApiBase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OAuthUser
 *
 * @ORM\Table(name="oauth_users", indexes={@ORM\Index(name="email_index", columns={"email"}), @ORM\Index(name="search_index", columns={"name", "email"})})
 * @ORM\Entity(repositoryClass="ApiBase\Repository\OAuthUserRepository")
 */
class OAuthUser extends EncryptableFieldEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=130, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity="ApiUser\Entity\UserDetail", mappedBy="user")
     */
    private $detail;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $this->encryptField($password);
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set detail.
     *
     * @param \ApiUser\Entity\UserDetail|null $detail
     *
     * @return UserDetail
     */
    public function setDetail(\ApiUser\Entity\UserDetail $detail = null)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail.
     *
     * @return \ApiUser\Entity\UserDetail|null
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Verify user's password
     *
     * @param string $password
     * @return Boolean
     */
    public function verifyPassword($password)
    {
        return $this->verifyEncryptedFieldValue($this->getPassword(), $password);
    }

    public function toArray()
    {
        return [
            'user_id' => $this->id,
            'scope'   => null,
        ];
    }
}
