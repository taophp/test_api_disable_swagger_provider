<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ActivationController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
    }

    #[Route('/users/activat/{token}', name: 'user_activat', methods: ['GET'], format: 'html')]
    public function activate(string $token): Response
    {
        $user = $this->userRepository->findOneBy(['activationToken' => $token]);

        if ($user && $user->activate($token)) {
            // Sauvegarder les modifications
            $this->entityManager->flush();

            // Réponse HTML en cas de succès
            return new Response('<html><body>User activated successfully!</body></html>');
        }

        // Réponse HTML en cas d'échec
        return new Response('<html><body>Invalid activation token.</body></html>', Response::HTTP_BAD_REQUEST);
    }
}
