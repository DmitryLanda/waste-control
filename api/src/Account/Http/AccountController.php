<?php

declare(strict_types=1);

namespace App\Account\Http;

use App\Account\Application\AccountService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users/{userId}')]
class AccountController extends AbstractController
{
    public function __construct(private AccountService $service)
    {
    }

    #[Route('/accounts', name: 'account.show', methods: ['GET'])]
    public function show(string $userId): Response
    {
        try {
            $accounts = $this->service->findByUserId($userId);
        } catch (Exception $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->json($accounts, Response::HTTP_OK);
    }
}
