<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="Notification")
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\NotificationRepository")
*/
class Notification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     * @Expose
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Expose
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="section", type="string", length=255)
     * @Expose
     */
    private $section;

    /**
     * @ORM\Column(name="sendAt", type="datetime")
     */
    protected $sendAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     * @ORM\JoinColumn(name="sentBy", referencedColumnName="id")
     */
    protected $sentBy;

    public function __construct()
    {
        $this->sendAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

    /**
     * @param mixed $sendAt
     */
    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;
    }

    /**
     * @return mixed
     */
    public function getSentBy()
    {
        return $this->sentBy;
    }

    /**
     * @param $sentBy
     */
    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;
    }
}
