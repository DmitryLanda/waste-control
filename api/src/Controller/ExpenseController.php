<?php

namespace App\Controller;

use App\Dto\MoneyRequest;
use App\Exceptions\ValidationException;
use App\Form\MoneyType;
use App\Services\ExpensesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpenseController extends AbstractController
{
    #[Route('/expenses', name: 'expenses.add')]
    public function addExpense(Request $request, ExpensesService $service): Response
    {
        $data = new MoneyRequest();
        $form = $this->createForm(MoneyType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->add($data);

            return $this->json(null, Response::HTTP_CREATED);
        }

        throw new ValidationException($form->getErrors(true));
    }
}
