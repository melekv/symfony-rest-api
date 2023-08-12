<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\RegisterDataException;
use App\Service\RegisterDataChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
        private RegisterDataChecker $dataChecker
    ) {
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $this->dataChecker->checkContentTypeFormat($request);

            $data = json_decode(
                $request->getContent(),
                true
            );

            $this->dataChecker->checkCredentialsPresence($data);
            $this->dataChecker->checkUserExists($data['email']);

            $user = $this->setData($data);
            $this->dataChecker->checkValidation($user);

        } catch (RegisterDataException $exception) {
            return $this->json([
                $exception->getMessage()
            ], $exception->getCode());
        }

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $data['password']
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($data);
    }

    private function setData(array $data): User
    {
        $user = new User();

        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($data['password']);
        $user->setFirstName($data['firstName'] ?? null);
        $user->setLastName($data['lastName'] ?? null);
        $user->setPhone($data['phone'] ?? null);

        return $user;
    }
}
