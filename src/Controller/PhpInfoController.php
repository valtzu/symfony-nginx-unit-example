<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class PhpInfoController
{
    #[Route('/')]
    public function phpinfo(): Response
    {
        return new StreamedResponse(fn () => phpinfo());
    }
}
