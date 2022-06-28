<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivreType;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{
    /**
     * function qui sert a afficher tous les livres
     *
     * @param LivresRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/livres', name: 'livres_index', methods: ['GET'])]
    public function index(LivresRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $livres = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            8
        );
        
        return $this->render('pages/livres/index.html.twig', [
            'livres' => $livres
        ]);
    }

    #[Route('/livres/nouveau', 'livres.new', methods:['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        ): Response
    {
        $livres = new livres();
        $form = $this->createForm(LivreType:: class, $livres);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $livres = $form->getData();

   
            $manager->persist($livres);
            $manager->flush();

            $this->addFlash(
                'Ca a marché ! Wahouuu',
                'Votre livre a bien été enregistré dans la base de donnée de Bibli'
            );

            return $this->redirectToRoute('livres_index');
        } 

        return $this->render('pages/livres/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
