<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//#[Route('/admin/images')]
class ImagesController extends AbstractController
{
    #[Route('/images', name: 'app_slide')]
    public function index(ImagesRepository $imagesRepository): Response
    {
        $images = $imagesRepository->findByPosition();

        return $this->render('home/inSlide.html.twig', [
            'images' => $images //$imagesRepository->findAll(),
        ]);
    }

    #[Route('/admin/images/{id<\d+>}', name: 'app_image_show')]
    public function show($id, ManagerRegistry $doctrine, ImagesRepository $imagesRepository, Request $request): Response
    {
        $image = $doctrine->getRepository(Images::class)->find($id);

        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagesRepository->add($image, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('images/show.html.twig', [
            'image' => $image,
            'formImages' => $form->createview()
        ]);
    }

    #[Route('/admin/images/delete_{id<\d+>}', name: 'app_image_delete')]
    public function delete($id, EntityManagerInterface $manager, ManagerRegistry $doctrine)
    {
       
        $image = $doctrine->getRepository(Images::class)->find($id);

        $manager->remove($image);

        $manager->flush();

        return $this->redirectToRoute('app_home');
    }
}
