<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="notifications")
 * @ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\NotificationRepository")
*/
class Notification
{
    const NOTIFICATION_TYPE_BACK_OFFICE = "BO";
    const NOTIFICATION_TYPE_DRUPAL = "DRUPAL";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="text")
     * @Expose
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text")
     * @Expose
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="section", inversedBy="notification")
     * @ORM\JoinColumn(name="section", referencedColumnName="codeSection")
     * @Expose
     */
    protected $section;

    /**
     * @ORM\Column(name="sentAt", type="datetime")
     * @Expose
     */
    protected $sentAt;

    /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="notifications")
     * @ORM\JoinColumn(name="sentBy", referencedColumnName="id")
     */
    protected $sentBy;

    /**
     * @ORM\Column(name="type", type="string")
     * @Expose
     */
    protected $type;

    /**
     * @ORM\Column(name="link", type="text", nullable=true)
     * @Expose
     */
    protected $link;

    public function __construct()
    {
        $this->sentAt = new \DateTime();
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
     *
     * @return Notification $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param Section $section
     *
     * @return Notification $this
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * @param \DateTime $sentAt
     *
     * @return Notification $this
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getSentBy()
    {
        return $this->sentBy;
    }

    /**
     * @param User $sentBy
     *
     * @return Notification $this
     */
    public function setSentBy(User $sentBy)
    {
        $this->sentBy = $sentBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Notification $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link) {
        $this->link = $link;
    }


}
