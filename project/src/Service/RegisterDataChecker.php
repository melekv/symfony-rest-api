<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\RegisterDataException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterDataChecker
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @throws RegisterDataException
     */
    public function checkContentTypeFormat(Request $request): void
    {
        if ($request->getContentTypeFormat() !== 'json') {
            throw new RegisterDataException(
                'Only JSON support',
                415
            );
        }
    }

    /**
     * @throws RegisterDataException
     */
    public function checkCredentialsPresence(array $data): void
    {
        if (!isset($data['email']) || !isset($data['password'])) {
            throw new RegisterDataException(
                'Missing credentials',
                400
            );
        }
    }

    /**
     * @throws RegisterDataException
     */
    public function checkUserExists(string $email): void
    {
        if (
            $this->entityManager
                ->getRepository(User::class)
                ->findOneBy([
                    'email' => $email
                ])
        ) {
            throw new RegisterDataException(
                'User already exists',
                422
            );
        }
    }

    /**
     * @throws RegisterDataException
     */
    public function checkValidation(User $user): void
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new RegisterDataException(
                (string) $errors,
                422
            );
        }
    }
}