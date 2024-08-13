<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @implements ProcessorInterface<User, User|void>
 */
final class UserProcessor implements ProcessorInterface
{
  public function __construct(
    #[Autowire(service: "api_platform.doctrine.orm.state.persist_processor")]
    private ProcessorInterface $persistProcessor,
    #[Autowire(service: "api_platform.doctrine.orm.state.remove_processor")]
    private ProcessorInterface $removeProcessor,
    private MailerInterface $mailer
  ) {
  }
  public function process(mixed $user, Operation $operation, array $uriVariables = [], array $context = []): mixed {
  dump(func_get_args());
    $data = json_decode($context['request']->getContent());
    $user->setEmail($data->email);
    $user->setPassword($data->password);
    $user->setActivationToken(bin2hex(random_bytes(32)));

    $result = $this->persistProcessor->process($user, $operation, $uriVariables, $context);
    $this->sendActivationEmail($user);
    return $result;
  }
  private function sendActivationEmail(User $user)
  {

      $email = (new Email())
          ->from('no-reply@testapi.com')
          ->to($user->getEmail())
          ->subject('Please confirm your email')
          ->html(sprintf('Please click <a href="%s/users/activate/%s">here</a> to activate your account.', $_ENV['APP_URL'], $user->getActivationToken()));

      $this->mailer->send($email);
  }
}
