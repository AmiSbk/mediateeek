<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur qui gère les routes de la page formations
 *
 */
class FormationsController extends AbstractController {

    /**
     * 
     * @var FormationRepository
     */
    
    private $formationRepository;
    

    
    /**
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    /**
     * constante qui mène à la page des formations
     */
    private const RETOURNEFORMATION = "pages/formations.html.twig";
    
    /**
     * Création du constructeur
     * @param FormationRepository $formationRepository
     * @param CategorieRepository $categorieRepository
     */
    function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * Création de la route qui dirige vers la page des formations
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::RETOURNEFORMATION, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * Tri des enregistrements en fonction du champ et de l'ordre et de la table si la table n'est pas vide
     * Tri des enregistrements en fosnction du champ et de l'ordre si la table est vide
     * @Route("/formations/tri/{champ}/{ordre}/{table}", name="formations.sort")
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
        return $this->render(self::RETOURNEFORMATION, [
            'formations' => $formations,
            'categories' => $categories,
            
        ]);
    }     
    
    /**
     * Tri des enregistrements en fonction du champ et de l'ordre et de la table si la table n'est pas vide
     * Tri des enregistrements en fosnction du champ et de l'ordre si la table est vide
     * @Route("/formations/recherche/{champ}/{table}", name="formations.findallcontain")
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
            return $this->render(self::RETOURNEFORMATION, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  
    
    /**
     * Récupère les informations d'une formation 
     * @Route("/formations/formation/{id}", name="formations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render("pages/formation.html.twig", [
            'formation' => $formation
        ]);        
    }   
    
}
