<?php

declare(strict_types=1);

namespace App\User\Http;

use App\User\Application\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UserController extends AbstractController
{
    public function __construct(private UserService $service)
    {

    }

    #[Route('/{id}', name: 'users.show', methods: ['GET'])]
    public function show(string $id): Response
    {
        $user = $this->service->findById($id);
        if (!$user) {
            throw $this->createNotFoundException();
        }

        return $this->json($user, Response::HTTP_OK);
    }

    #[Route(name: 'users.add', methods: ['POST'])]
    #[ParamConverter('request', converter: 'json_converter')]
    public function register(CreateUser $request): Response
    {
        $user = $this->service->register($request);

        return $this->json($user, Response::HTTP_OK);
    }
}
