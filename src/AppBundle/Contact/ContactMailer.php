<?php

namespace AppBundle\Contact;

class ContactMailer
{
    private $mailer;
    private $sendTo;

    public function __construct(\Swift_Mailer $mailer, string $sendTo)
    {
        $this->mailer = $mailer;
        $this->sendTo = $sendTo;
    }

    public function sendMessage(Message $message): bool
    {
        $mail = new \Swift_Message($message->getSubject() ?: 'Default subject', $message->getContent());
        $mail->setFrom($message->getEmail(), $message->getName());
        $mail->setTo($this->sendTo);

        return $this->mailer->send($mail);
    }
}
