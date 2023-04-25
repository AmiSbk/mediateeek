<?php

namespace App\Controller\admin;

use App\Form\FormationType;
use App\Entity\Formation;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminFormationsController
 *
 */
class AdminFormationsController  extends AbstractController {
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;

    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;

    private const RETOURNEPFORMATION = "admin/admin.formations.html.twig";
    private const RETOURNEADMINFORMATION = "admin.formations";


      public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }
    
    /**
     * Route admin qui redirige vers la page de formation
     * @Route("/admin", name="admin.formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->formationRepository->findAllOrderBy('title', 'ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.formations.html.twig", [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * Tri des enregistrements en fonction du champ et de l'ordre et de la table si la table n'est pas vide
     * Tri des enregistrements en fonction du champ et de l'ordre si la table est vide

     * @Route("/admin/formations/tri/{champ}/{ordre}/{table}", name="admin.formations.sort")
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    public function sort($champ, $ordre, $table=""): Response{
         if($table !="")
        {
            $formations = $this->formationRepository->findAllOrderByT($champ, $ordre, $table);
        }else 
        {
            $formations = $this->formationRepository->findAllOrderBy($champ, $ordre);
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::RETOURNEPFORMATION, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }     

    /**
     * Recherche en fonction du champ et de l'ordre et de la table si la table n'est pas vide
     * Recherche en fonction du champ et de l'ordre si la table est vide
     * @Route("/admin/formations/recherche/{champ}/{table}", name="admin.formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        if($table !="")
        {
            $formations = $this->formationRepository->findByContainValueT($champ, $valeur, $table);
        }else 
        {
            $formations = $this->formationRepository->findByContainValue($champ, $valeur);
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::RETOURNEPFORMATION, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  


    /**
     * Création d'un formulaire avec contrôle sur la validité de la date
     * Retourne sur la page admin des formations
     * @Route("/admin/ajout", name="admin.formation.ajout")
     * @param Request $request
     * @return Response
     */
     public function ajout( Request $request): Response
    {
        $formations = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formations);

        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted()&& $formFormation->isValid()){
            if ($this->isValidDate($formations->getPublishedAt())) {
                $this->formationRepository->add($formations, true);
            }            

            return $this->redirectToRoute(self::RETOURNEADMINFORMATION);
        }

        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formations' => $formations,
            'formFormation' => $formFormation->createView()
        ]);
    }

     /**
     * Modification d'un formulaire avec contrôle sur la validité de la date
     * Retourne sur la page admin des formations
     * @Route("/admin/edit/{id}", name="admin.formation.edit")
     * @param Formation $formations
     * @param Request $request
     * @return Response
     */
     public function edit(Formation $formations, Request $request): Response
    {
        $formFormation = $this->createForm(FormationType::class, $formations);

        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted()&& $formFormation->isValid()){
            if ($this->isValidDate($formations->getPublishedAt())) {
                $this->formationRepository->add($formations, true);
            }
            return $this->redirectToRoute(self::RETOURNEADMINFORMATION);
        }

        return $this->render("admin/admin.formation.edit.html.twig", [
            'formations' => $formations,
            'formFormation' => $formFormation->createView()
        ]);


    }


    /**
     * Suppression d'une formation et redirection sur la page admin.formation
     * @Route("/admin/suppr/{id}", name="admin.formation.suppr")
     * @param Formation $formations
     * @return Response
     */
    public function suppr(Formation $formations): Response
    {
        $this->formationRepository->remove($formations,true);
        return $this->redirectToRoute(self::RETOURNEADMINFORMATION);

    }
    
    /**
     * fonction de contrôle sur la validité de la date
     */
    public function isValidDate($date): bool
    {
        return $date<=new \DateTime('now');
    }
}
