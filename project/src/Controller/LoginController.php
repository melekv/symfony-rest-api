<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\User;
use App\Repository\ApiTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    public function __construct(private ApiTokenRepository $apiTokenRepository)
    {
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        if ($user === null) {
            return $this->json([
                'error' => 'Missing credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // token
        $token = bin2hex(random_bytes(32));

        $apiToken = new ApiToken();
        $apiToken->setUser($user);
        $apiToken->setToken($token);

        $this->apiTokenRepository->save($apiToken, true);

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => $token
        ]);
    }
}
