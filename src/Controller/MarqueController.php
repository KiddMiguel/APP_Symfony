<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/marque')]
class MarqueController extends AbstractController
{
    #[Route('/', name: 'app_marque')]
    public function index(EntityManagerInterface $em, Request $request, LoggerInterface $logger): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logger->error('1');
            $logoFile = $form->get('logo')->getData();
            if ($logoFile) {
                $logger->error('2');
                $newFilename = uniqid() . '.' . $logoFile->guessExtension();

                try {
                    $logger->error('3');
                    $logoFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                    $logger->error('4');
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Impossible d\'ajouter l\'image');
                }

                $marque->setLogo($newFilename);
            }

            $em->persist($marque);
            $em->flush();

            $this->addFlash('success', 'Marque ajouté ✔️');
        }

        // Récupération des catégories (SELECT *)
        $marques = $em->getRepository(Marque::class)->findAll();


        return $this->render('marque/index.html.twig', [
            'marques' => $marques,
            'ajout' => $form->createView()
        ]);
    }
    #[Route('/{id}', name: 'marque')]
    public function marque(Marque $marque = null, Request $request, EntityManagerInterface $em): Response
    {
        if ($marque == null) {
            $this->addFlash('danger', 'Marque introuvable arrête 😭😭😭 !!');
            return $this->redirectToRoute('app_marque');
        }

        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $logoFile = $form->get('logo')->getData();
            if ($logoFile) {
                $newFilename = uniqid() . '.' . $logoFile->guessExtension();

                try {
                    $logoFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Impossible de modifier l\'image');
                }

                $marque->setLogo($newFilename);
            }

            $em->persist($marque);
            $em->flush();

            $this->addFlash('success', 'Marque mise à jour ☠️☠️☠️');
        }
        $marques = $em->getRepository(Marque::class)->findAll();

        return $this->render('marque/show.html.twig', [
            'marques' => $marques,
            'uneMarque' => $marque,
            'edit' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'marque_delete')]
    public function delete(Marque $marque = null, EntityManagerInterface $em)
    {
        if ($marque == null) {
            $this->addFlash('danger', 'Marque introuvable arrête 😭😭😭 !!');
            return $this->redirectToRoute('app_marque');
        }
        $em->remove($marque);
        $em->flush();


        $this->addFlash('warning', 'Marque supprimée, t\'es fière ? 🙄');
        return $this->redirectToRoute('app_marque');
    }
}
