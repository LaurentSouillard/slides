<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/admin/home', name: 'app_home')]
    public function index(UserRepository $userRepository): Response
    {
       /* $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request); */
        //dd($data);
       
        //$images = $imagesRepository->findSearch($data);

        // ********** Je garde si jamais  **********
        /*$donnees = $doctrine->getRepository(Images::class)->findAll();
        // Pagination
        $images = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos images $donnees)
            $request->query->getInt('page', 1), // Numéro de la page en cours passé dans l'URL soit page 1 si jamais aucune page
            15 // Nombre de résultats par page
        );
         ********** ***** **********/
        //return $this->redirectToRoute('app_dashboard');

        return $this->render('home/index.html.twig',[
            'users' => $userRepository->findAll()
        ]); /*[
            'images' => $imagesRepository->findAll(),// $images
            //'formSearch' => $form->createView(),
        ]);*/
    }
}
