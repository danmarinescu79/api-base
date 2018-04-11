<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:18:53
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:45:59
 */

namespace ApiBase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OAuthRefreshToken
 *
 * @ORM\Table(name="oauth_refresh_tokens")
 * @ORM\Entity(repositoryClass="ApiBase\Repository\OAuthRefreshTokenRepository")
 */
class OAuthRefreshToken
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
     * @ORM\Column(name="refresh_token", type="string", length=40, unique=true)
     */
    private $refresh_token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires",type="datetime", nullable=false)
     */
    private $expires;

    /**
     * @var string
     *
     * @ORM\Column(name="scope", type="string", length=50, nullable=true)
     */
    private $scope;

    /**
     * @var \ApiBase\Entity\OAuthClient
     *
     * @ORM\ManyToOne(targetEntity="\ApiBase\Entity\OAuthClient")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @var \ApiBase\Entity\OAuthUser
     *
     * @ORM\ManyToOne(targetEntity="\ApiBase\Entity\OAuthUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set refresh_token
     *
     * @param string $refresh_token
     * @return OAuthRefreshToken
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;

        return $this;
    }

    /**
     * Get refresh_token
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     * @return OAuthRefreshToken
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set scope
     *
     * @param string $scope
     * @return OAuthRefreshToken
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set client
     *
     * @param \ApiBase\Entity\OAuthClient $client
     * @return OAuthRefreshToken
     */
    public function setClient(\ApiBase\Entity\OAuthClient $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \ApiBase\Entity\OAuthClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set user
     *
     * @param \ApiBase\Entity\OAuthUser $user
     * @return OAuthRefreshToken
     */
    public function setUser(\ApiBase\Entity\OAuthUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ApiBase\Entity\OAuthUser
     */
    public function getUser()
    {
        return $this->user;
    }

    public function toArray()
    {
        return [
            'refresh_token' => $this->refresh_token,
            'client_id'     => $this->client->getClientIdentifier(),
            'user_id'       => !empty($this->user) ? $this->user->getId() : null,
            'expires'       => $this->expires,
            'scope'         => $this->scope,
        ];
    }

    public static function fromArray($params)
    {
        $token = new self();
        foreach ($params as $property => $value) {
            $token->$property = $value;
        }
        return $token;
    }
}
