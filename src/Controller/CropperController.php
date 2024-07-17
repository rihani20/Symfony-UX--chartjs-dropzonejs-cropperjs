<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Cropperjs\Factory\CropperInterface;
use Symfony\UX\Cropperjs\Form\CropperType;

class CropperController extends AbstractController
{

    #[Route('/cropper', name: 'cropper', methods: ['GET'])]

    public function index(CropperInterface $cropper, Request $request): Response
    {
        // Créez une instance de recadrage pour l'image
        $crop = $cropper->createCrop('image.jpg');
        // Définissez la taille maximale du recadrage
        $crop->setCroppedMaxSize(2000, 1500);

        // Créez le formulaire avec le type CropperType
        $form = $this->createFormBuilder(['crop' => $crop])
            ->add('crop', CropperType::class, [
                'public_url' => 'image.jpg',
                'cropper_options' => [
                    'aspectRatio' => 2000 / 1500,
                ],
            ])
            ->getForm();

        // Traitez la requête du formulaire
        $form->handleRequest($request);

        // Vérifiez si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenez les données de l'image recadrée (en tant que chaîne de caractères)
            $croppedImage = $crop->getCroppedImage();

            // Créez une miniature de l'image recadrée (en tant que chaîne de caractères)
            $thumbnail = $crop->getCroppedThumbnail(200, 150);

            // Faites quelque chose avec les données de l'image recadrée et la miniature
            // Par exemple, enregistrez-les sur le disque, ou utilisez-les dans votre application

            // Ajoutez votre logique ici...

            // Redirigez ou renvoyez une réponse appropriée après le traitement du formulaire
            return $this->redirectToRoute('crop_success');
        }

        // Renvoyez le formulaire à la vue
        return $this->render('cropper/index.html.twig', [
            'controller_name' => 'CropperController',
            'form' => $form->createView(),
        ]);
    }
}
