<?php

namespace App\Classes;

use App\Entity\Customer;
use App\Entity\Order;
use Twig\Environment;

class Mailer{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;


    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(
        \Swift_Mailer $mailer,
        Environment $twig
)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmationEmail(Customer $customer, string $locale)
    {
        $path = ($locale == "en") ? 'emails/register-confirmation.html.twig' : 'emails/register-confirmationAr.html.twig';
        $body = $this->twig->render($path,
            [
                'customer' => $customer,
                'locale' => $locale
            ]
        );
        $message = (new \Swift_Message('Please confirm your account'))
            ->setFrom('noreply@agence.fr')
            ->setTo($customer->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendResetPasswordEmail($customer, $resetToken, $tokenLifetime)
    {
        $body = $this->twig->render('emails/reset-password.html.twig', [
                'resetToken' => $resetToken,
                'tokenLifetime' => $tokenLifetime,
            ]
        );
        $message = (new \Swift_Message('Your password reset request'))
            ->setFrom('noreply@agence.fr')
            ->setTo($customer->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendContactEmail(Contact $contact)
    {
        $body = $this->twig->render('emails/contact.html.twig', [
                'contact' => $contact
            ]
        );
        $message = (new \Swift_Message('FoodShack : '))
            ->setFrom('noreply@agence.fr')
            ->setTo($contact->getEmail())
            ->setReplyTo($contact->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendSuccessOrderEmail(Order $order)
    {
        $body = $this->twig->render('order/success.html.twig',
            [
                'order' => $order
            ]
        );
        $message = (new \Swift_Message('Please confirm your account'))
            ->setFrom('noreply@agence.fr')
            ->setTo($order->getShippingEmail())
            ->setReplyTo($order->getShippingEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendFailureOrderEmail(Order $order)
    {
        $body = $this->twig->render('order/failure.html.twig',
            [
                'order' => $order
            ]
        );
        $message = (new \Swift_Message('Please confirm your account'))
            ->setFrom('noreply@agence.fr')
            ->setTo($order->getShippingEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}