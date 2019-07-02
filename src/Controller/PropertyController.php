<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends AbstractController{



    private $repository;
    
    public function __construct(PropertyRepository $repository){
        $this->repository=$repository;
    }

    /**
     * @Route("/biens",name="property.index")
     * @return
     */
    public function index():Response{

/*         $property= new Property();
        $property->setTitle('Mon premier bien')
        ->setSold(false)
        ->setRooms(4)
        ->setBedrooms(3)
        ->setDescription("Une description inutile")
        ->setSurface(61)
        ->setFloor(4)
        ->setPrice(100000)
        ->setCity('Clamart');
        $em=$this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush(); */
        $property=$this->repository->findNonSold();
        dump($property);

        return $this->render('property/index.html.twig',[
            'current_menu' => 'properties'
        ]);
    }

     /**
     * @Route("/biens/{slug}-{id}", name="property.show",requirements={"slug":"[a-zA-Z1-9\-_\/]*"})
     * @return
     */
    public function show($slug,$id): Response{

        $property=$this->repository->find($id);
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}