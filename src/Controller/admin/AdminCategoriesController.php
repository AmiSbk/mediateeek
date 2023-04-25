<?php


namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminCategoriesController
 *
 */
class AdminCategoriesController extends AbstractController{

    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;

     /**
     * @var FormationRepository
     */
    private $formationRepository;


    /**
     * Création du constructeur
     * @param CategorieRepository $categorieRepository
     * @param formationRepository $formationRepository
     */
    public function __construct( CategorieRepository $categorieRepository,formationRepository $formationRepository) {
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRepository;

    }   



    /**
     * Route admin qui dirige vers les catégories
     * @Route("/admin/categorie", name="admin.categorie")
     * @return Response
     */
     public function index(): Response
    {

        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.categorie.html.twig', [
            'categories' => $categories          
        ]);
    }



    /**
     * fonction pour supprimer une catégorie 
     * @Route("/admin/categorie/suppr/{id}", name="admin.categorie.suppr")
     * @param Categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie): Response{
        $this->categorieRepository->remove($categorie, true);
        return $this->redirectToRoute('admin.categorie');
    }

    /**
     * fonction pour ajouter une catégorie
     * @Route("/admin/categorie/ajout", name="admin.categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $name = $request->get("name");
        $categories = new Categorie();
        $categories->setName($name);
        $this->categorieRepository->add($categories, true);
        return $this->redirectToRoute('admin.categorie');       
    }        

}