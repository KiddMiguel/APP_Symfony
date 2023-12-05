<?php

namespace App\Controller;

use App\Entity\Model;
use App\Form\ModelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/model')]
class ModelController extends AbstractController
{
    #[Route('/', name: 'app_model')]
    public function index(EntityManagerInterface $em, Request $request): Response{
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em->persist($model);
            $em->flush();
            $this->addFlash('success','Model ajouté ✔️');
        }
        
        // Récupération des catégories (SELECT *)
        $models = $em->getRepository(Model::class)->findAll();


        return $this->render('model/index.html.twig', [
            'models' => $models,  
            'ajout'=> $form->createView()
        ]);
    }
    #[Route('/{id}', name: 'model')]
    public function model (Model $model = null, Request $request, EntityManagerInterface $em) :Response{
        if ($model == null) {
            $this->addFlash('danger', 'Model introuvable arrête 😭😭😭 !!');
            return $this->redirectToRoute('app_model');
        }

        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($model);
            $em->flush();

            $this->addFlash('success', 'Model mise à jour ☠️☠️☠️');
        }
        $models = $em->getRepository(Model::class)->findAll();

        return $this->render('model/show.html.twig', [
            'models' => $models,  
            'UnModel' => $model,
            'edit' => $form->createView()   
        ]);
    }

    #[Route('/delete/{id}', name:'model_delete')]
    public function delete(Model $model= null, EntityManagerInterface $em){
        if($model == null){
            $this->addFlash('danger', 'Model introuvable arrête 😭😭😭 !!');
            return $this->redirectToRoute('app_model');
        }
        $em->remove($model);
        $em->flush();

        
        $this->addFlash('warning', 'model supprimée, t\'es fière ? 🙄');
        return $this->redirectToRoute('app_model');
    }
    
}
