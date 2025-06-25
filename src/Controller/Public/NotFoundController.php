<?php

declare(strict_types=1);

namespace App\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/not-found', name: 'not_found')]
class NotFoundController extends AbstractController
{
    public function __invoke(): Response {
        return $this->render('error/not_found.html.twig');
    }
}