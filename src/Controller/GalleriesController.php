<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Galleries;
use App\Form\GalleriesType;
use App\Repository\GalleriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/galleries')]
class GalleriesController extends AbstractController
{
    #[Route('/', name: 'app_galleries')]
    public function index(): Response
    {
        return $this->render('galleries/index.html.twig', [
            'controller_name' => 'GalleriesController',
        ]);
    }

    #[Route('/new', name: 'app_gallery_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GalleriesRepository $galleriesRepository, EntityManagerInterface $manager, ManagerRegistry $doctrine): Response
    {
        $gallery = new Galleries();
        $form = $this->createForm(GalleriesType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galleriesRepository->add($gallery, true);

            // On récupère les images transmises
            $images = $form->get('images')->getData();
            
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                
                // On copie le fichier dans le dossier img
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setNom($fichier);
                $gallery->addImage($img);
            }

            $manager = $doctrine->getManager();

            $manager->persist($gallery);

            $manager->flush();

            return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('galleries/ajoutImages.html.twig', [
            'gallery' => $gallery,
            'formImages' => $form->createView(),
        ]);
    }
}
