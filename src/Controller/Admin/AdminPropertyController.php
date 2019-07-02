<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminPropertyController extends AbstractController{

    private $repository;
    private $em;
    
    public function __construct(PropertyRepository $repository,ObjectManager $em){
        $this->repository=$repository;
        $this->em=$em;
    }

    /**
     * @Route("/admin",name="admin.property.index")
     * @return
     */
    public function index(PropertyRepository $repository): Response{
        $properties=$this->repository->findAll();

        return $this->render('admin/property/index.html.twig',[
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/admin/property/new",name="admin.property.new")
     * @return
     */
    public function new(Request $request){
        $property=new Property();
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Création effectuée');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig',[
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/{id}",name="admin.property.edit" ,methods="GET|POST")
     * @return
     */
    public function edit(Property $property,Request $request){
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Modifications effectuées');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig',[
            'property' => $property,
            'form' => $form->createView()
        ]); 
    }

    /**
     * @Route("/admin/delete/{id}",name="admin.property.delete",methods="DELETE")
     * @return
     */
    public function delete(Property $property,Request $request){
        if($this->isCsrfTokenValid('delete'.$property->getId(),$request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Suppression effectuée'); 
        }
        return $this->redirectToRoute('admin.property.index');
    }
}