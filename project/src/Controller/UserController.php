<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    // get all users
    #[Route('/', name: 'all', methods: ['GET'])]
    public function users(): JsonResponse
    {
        return $this->json([
            'get list of users'
        ]);
    }

    // get 1 user
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function user(): JsonResponse
    {
        return $this->json([
            'get one user'
        ]);
    }

    // add user
    #[Route('/', name: 'add', methods: ['POST'])]
    public function userAdd(): JsonResponse
    {
        return $this->json([
            'add user'
        ]);
    }

    // edit user
    #[Route('/{id}', name: 'edit', methods: ['PATCH'])]
    public function userEdit(): JsonResponse
    {
        return $this->json([
            'edit user'
        ]);
    }

    // delete user
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function userDelete(): JsonResponse
    {
        return $this->json([
            'delete user'
        ]);
    }
}
