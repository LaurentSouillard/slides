<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Categories;
use App\Form\GalleriesType;
use App\Repository\ImagesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/{id<\d+>}', name: 'app_categorie')]
    public function index($id, ManagerRegistry $doctrine, ImagesRepository $imagesRepository, CategoriesRepository $categoriesRepository): Response
    {
        $categorie = $doctrine->getRepository(Categories::class)->find($id);
        //dd($categorie);
        $images = $imagesRepository->findByPosition();
        
        return $this->render('categories/slideShow.html.twig', [
            'categorie' => $categorie,
            //'categories' => $categoriesRepository->findAll(),
            'images' => $images
        ]);
    }

    #[Route('/admin/categories', name: 'app_categories')]
    public function show(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories/lesCategories.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/admin/update_{id<\d+>}', name: 'app_categorie_update')]
    public function update($id, CategoriesRepository $categoriesRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $categorie = $doctrine->getRepository(Categories::class)->find($id);

        $form = $this->createForm(GalleriesType::class, $categorie);
        $form->handleRequest($request);

       /* if ($form->isSubmitted() && $form->isValid()) {
            $themesRepository->add($theme, true);

            return $this->redirectToRoute('app_themes', [], Response::HTTP_SEE_OTHER);
        } */

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->add($categorie, true);

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
                $categorie->addImage($img);
            }

            $manager = $doctrine->getManager();

            $manager->persist($categorie);

            $manager->flush();

            return $this->redirectToRoute('app_categories', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('galleries/ajoutImages.html.twig', [
            'formImages' => $form->createview(),
        ]);
    }

    #[Route('/admin/delete_{id<\d+>}', name: 'app_categorie_delete')]
    public function delete($id, EntityManagerInterface $manager, ManagerRegistry $doctrine)
    {
        $categorie = $doctrine->getRepository(Categories::class)->find($id);

        $manager->remove($categorie);

        $manager->flush();

        return $this->redirectToRoute('app_categories');
    }
}
