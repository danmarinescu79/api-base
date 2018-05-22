<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 14:16:39
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-05-22 18:39:58
 */

namespace ApiBase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OAuthUser
 *
 * @ORM\Table(name="oauth_users", indexes={@ORM\Index(name="email_index", columns={"email"}), @ORM\Index(name="search_index", columns={"first_name", "last_name", "email"})})
 * @ORM\Entity(repositoryClass="ApiBase\Repository\OAuthUserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class OAuthUser extends EncryptableFieldEntity
{
    const STATUS = [
        0 => 'Deleted',
        1 => 'Active',
    ];
    const DELETED = 0;
    const ACTIVE  = 1;

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
     * @ORM\Column(name="first_name", type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

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
     * $var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = self::ACTIVE;

    /**
     * @ORM\ManyToOne(targetEntity="OAuthUser")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="OAuthUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

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
     * @return OAuthUser
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
     * Set firstName
     *
     * @param string $firstName
     * @return OAuthUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return OAuthUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return OAuthUser
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
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return OAuthUser
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return OAuthUser
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdBy.
     *
     * @param \ApiBase\Entity\OAuthUser|null $createdBy
     *
     * @return OAuthUser
     */
    public function setCreatedBy(\ApiBase\Entity\OAuthUser $createdBy = null)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return \ApiBase\Entity\OAuthUser|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy.
     *
     * @param \ApiBase\Entity\OAuthUser|null $updatedBy
     *
     * @return OAuthUser
     */
    public function setUpdatedBy(\ApiBase\Entity\OAuthUser $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * Get updatedBy.
     *
     * @return \ApiBase\Entity\OAuthUser|null
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set status.
     *
     * @param bool $status
     *
     * @return OAuthUser
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
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
