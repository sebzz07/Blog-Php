<?php

namespace SebDru\Blog\Controller;

use Exception;

class SendAnEmail
{
    private string $headers = "From: sebzz13test@gmail.com";
    private string $receiver = "sebzz13test@gmail.com";
    private string $subject = "Contact via Php-Blog";

    public function sendmail(array $post)
    {
        extract($post);
        $bodyMail = "Message provenant de : " . $contactName .
            "\r\n Mail du contact :" . $contactEmail .
            ("\r\n Téléphone du contact :" . $ContactPhoneNumber) .
            "\r\n Message du contact :" . $message;

        if (mail($this->receiver, $this->subject, $bodyMail, $this->headers)) {
            $this->twig->display('frontOffice/contact.html.twig', ["sucess" => true]);
        } else {
            throw new \Exception('Échec de l\'envoi de l\'email...');
        }
    }
}
