<?php

namespace AppBundle\Contact;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=255)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(min=2, max=255)
     */
    private $email;

    /**
     * @Assert\Length(min=2, max=255)
     */
    private $subject;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=20, max=1200)
     */
    private $content;

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

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
}
