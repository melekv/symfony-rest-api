<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/api', name: 'api_post_')]
class PostController extends AbstractController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    #[Route('/post/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, #[CurrentUser] ?User $user): JsonResponse {
        $post = $this->userRepository
            ->find($user->getId())
            ->getPosts()
            ->filter(function($element) use ($id) {
                if ($element->getId() === $id) {
                    return $element;
                }
            })
            ->getValues()
        ;

        return $this->json(
            $post,
            200,
            [],
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'title',
                    'content',
                    'createdAt',
                    'user' => ['id']
                ]
            ]
        );
    }

    #[Route('/post', name: 'all', methods: ['GET'])]
    public function all(#[CurrentUser] ?User $user): JsonResponse {
        $posts = $this->userRepository
            ->find($user->getId())
            ->getPosts()
            ->getValues()
        ;

        return $this->json(
            $posts,
            200,
            [],
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'title',
                    'content',
                    'createdAt',
                    'user' => ['id']
                ]
            ]
        );
    }

    // add post
    // edit post
    // delete post
}
