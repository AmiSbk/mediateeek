<?php
namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur qui gère les routes de la page d'accueil
 *
 */
class AccueilController extends AbstractController{
      
    /**
     * @var FormationRepository
     */
    private $repository;
    
    /**
     * Création du constructeur
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }   
    
    /**
     * Route qui dirige vers la page d'accueil
     * @Route("/", name="accueil")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->repository->findAllLasted(2);
        return $this->render("pages/accueil.html.twig", [
            'formations' => $formations
        ]); 
    }
    
    /**
     * Route qui dirige vers les conditions générales d'uilisation
     * @Route("/cgu", name="cgu")
     * @return Response
     */
    public function cgu(): Response{
        return $this->render("pages/cgu.html.twig"); 
    }
}
