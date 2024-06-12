<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\GroupeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupeRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/groupe')]
class GroupeController extends AbstractController
{
    #[Route('/', name: 'app_groupe', methods: ['GET'])]
    public function index(GroupeRepository $groupeRepository): Response
    {
        return $this->render('groupe/index.html.twig', [
            'groupes' => $groupeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/groupe/new", name="groupe_new")
     */
    #[Route('/new', name: 'app_groupe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $groupe->setChef($user); // Assigner l'utilisateur actuel comme chef
            $groupe->addUser($user); // Lier le groupe créé à l'utilisateur
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('app_groupe');
        }

        return $this->renderForm('groupe/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_groupe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Groupe $groupe, GroupeRepository $groupeRepository): Response
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $groupeRepository->save($groupe, true);

            //return $this->redirectToRoute('app_groupe');
        }

        return $this->renderForm('groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groupe_delete', methods: ['POST'])]
    public function delete(Request $request, Groupe $groupe, GroupeRepository $groupeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $groupeRepository->remove($groupe, true);
        }

        return $this->redirectToRoute('app_groupe', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/show/{id}', name: 'app_show', methods: ['GET'])]
    public function show(Groupe $groupe): Response
    {
        return $this->render('groupe/show.html.twig', [
            'groupe' => $groupe,
        ]);
    }

    #[Route('/join/{id}', name: 'app_groupe_join', methods: ['POST'])]
    public function join(Groupe $groupe, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        dump($groupe);
        $user = $this->getUser();

        if ($groupe->getPlacesRestantes() == 0) {
            $this->addFlash('error', 'Le groupe est complet.');
            return $this->redirectToRoute('app_groupe_index', ['id' => $groupe->getId()]);
        }
      
        $groupe->addUser($user);
        $entityManager->persist($groupe);
        $entityManager->flush();
       

            $this->addFlash('error', 'rejoint.');
            //$this->addFlash('error', 'Pas de groupe groupe.');
        dump($user);
        return $this->redirectToRoute('app_groupe');
    }

    #[Route('/quit/{id}', name: 'app_groupe_quit', methods: ['POST'])]
    public function leave(Groupe $groupe, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($groupe->getUsers()->contains($user)) {
            $groupe->removeUser($user);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez quitté le groupe.');
        } else {
            $this->addFlash('error', 'Vous ne faites pas partie de ce groupe.');
        }

        return $this->redirectToRoute('app_groupe');
    }
}
