<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function index(): Response
    {
        $upload = new Upload();

        $form = $this->createForm(UploadType::class, $upload);

        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
            'form' => $form->createView(),
        ]);
    }
}
