<?php

namespace App\Controller;

use App\Dto\ImageDto;
use App\Form\ImageType;
use App\Service\FormError;
use App\Service\Image as ImageService;
use App\Service\ImageView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/image", name="image_")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }


    /**
     * @Route("/list", name="list")
     * @param ImageView $imageViewService
     *
     * @return JsonResponse
     */
    public function imageList(ImageView $imageViewService)
    {
        return $this->json($imageViewService->getList());
    }

    /**
     * @Route("/create", name="create")
     *
     * @param Request $request
     * @param ImageView $imageViewService
     * @param ImageService $imageService
     *
     * @param FormError $errorService
     * @return JsonResponse
     */
    public function imageCreate(Request $request, ImageView $imageViewService, ImageService $imageService, FormError $errorService)
    {
        $form = $this->createForm(ImageType::class, new ImageDto());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $image = $imageService->create($form->getData());

            return $this->json($imageViewService->singleImage($image));
        }

        return $this->json([
            'errors' => $errorService->toArray($form),
        ]);
    }
}
