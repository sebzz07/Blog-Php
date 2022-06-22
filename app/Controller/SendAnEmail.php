<?php

namespace SebDru\Blog\Controller;

use Exception;

class SendAnEmail extends Controller
{
    private string $headers;
    private string $receiver;
    private string $subject = "Contact from Php-Blog";

    public function sendmail(array $post)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
        $dotenv->load();
        try {
            $emailDestination = $_ENV['EMAIL_CONTACT'];
            $this->headers = "From: " . $emailDestination;
            $this->receiver = $emailDestination;
            extract($post);

            if (strlen($contactName) <= 3 || strlen($contactName) >= 70 || preg_match('/[\/@\^\[\.\$\{\*\(\\\+\)\|\?\<\>]/', $contactName)) {
                throw new Exception("le nom n'est pas valide (caractères non-autorisées : @, ^, [, ., $, {, *, (, /,\ ,+ , ), |, ?,< ,>) et doit avoir entre 3 et 70 caratères");
            }
            if (null == filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("L'email est manquant ou n'est pas au bon format");
            }

            $message = wordwrap($message, 70, "\r\n");

            $bodyMail = "Message provenant de : " . $contactName .
                "\r\n\r\n Mail du contact : " . $contactEmail .
                "\r\n\r\n Message du contact :\r\n" . $message;

            if (mail($this->receiver, $this->subject, $bodyMail, $this->headers)) {
                $this->twig->display('frontOffice/contact.html.twig', ['success' => true]);
            } else {
                throw new \Exception('Échec de l\'envoi de l\'email...');
            }
        } catch (Exception $exception) {
            $errors['sendmail'] = $exception->getMessage();
            $this->twig->display('frontOffice/contact.html.twig', compact('errors'));
        }
    }
}
