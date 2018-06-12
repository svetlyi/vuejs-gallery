<?php

namespace App\Controller;

use App\Dto\ImageDto;
use App\Form\ImageType;
use App\Service\FormErrorService;
use App\Service\ImageService;
use App\Service\ImageViewService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/image", name="image_")
 */
class ImageController extends Controller
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
     * @param ImageViewService $imageViewService
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function imageList(ImageViewService $imageViewService)
    {
        return $this->json($imageViewService->getList());
    }

    /**
     * @Route("/create", name="create")
     *
     * @param Request $request
     * @param ImageViewService $imageViewService
     * @param ImageService $imageService
     *
     * @param FormErrorService $errorService
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function imageCreate(Request $request, ImageViewService $imageViewService, ImageService $imageService, FormErrorService $errorService)
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
