<?php

namespace App\Controller;

use App\Dto\ExpenseRequest;
use App\Exceptions\ValidationException;
use App\Form\ExpenseType;
use App\Services\CategoriesService;
use App\Services\ExpensesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'categories.list')]
    public function categories(CategoriesService $service): Response
    {
        return $this->json($service->getCategories());
    }
}
