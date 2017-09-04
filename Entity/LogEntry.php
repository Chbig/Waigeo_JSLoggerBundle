<?php

namespace Waigeo\JSLoggerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Représente un log d'une erreur Javascript
 *
 * @ORM\Table(name="jslogger_logentries")
 * @ORM\Entity(repositoryClass="Waigeo\JSLoggerBundle\Repository\LogEntryRepository")
 */
class LogEntry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="userAgent", type="string", nullable=false)
     */
    private $userAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", nullable=false)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="lineNumber", type="string", nullable=true)
     */
    private $lineNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="colNumber", type="string", nullable=true)
     */
    private $colNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime", nullable=true)
     */
    private $createdDate = null;

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
     * Set name
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set lineNumber
     *
     * @param string $lineNumber
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * Get $lineNumber
     *
     * @return string
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * Set colNumber
     *
     * @param string $colNumber
     */
    public function setColNumber($colNumber)
    {
        $this->colNumber = $colNumber;

        return $this;
    }

    /**
     * Get $colNumber
     *
     * @return string
     */
    public function getColNumber()
    {
        return $this->colNumber;
    }

    /**
     * Set createdDate
     *
     * @param string $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }
}
