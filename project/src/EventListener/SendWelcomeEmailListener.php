<?php

namespace App\EventListener;

use App\Event\UserRegisteredEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsEventListener]
class SendWelcomeEmailListener
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(UserRegisteredEvent $event): void
    {
        $email = (new TemplatedEmail())
            ->from('hi@op.pl')
            ->to('marekwitkowski89@gmail.com')
            ->subject('Welcome!')
            ->htmlTemplate('emails/signup.html.twig')
            ->context([
                'userEmail' => 'email@p.pl'
            ])
        ;

        $this->mailer->send($email);
    }
}