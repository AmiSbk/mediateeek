<?php

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 */
class CategorieRepositoryTest extends KernelTestCase{

    /**
     * Récupère le repository de Catégorie
     */
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }

    /**
     * Test sur la méthode testNbCategories
     */
    public function testNbCategories(){
        $repository = $this->recupRepository();
        $nbCategories = $repository->count([]);
        $this->assertEquals(10, $nbCategories);
    }

    /**
     * Création d'une instance de Catégorie avec les champs
     * @return Categorie
     */
    public function newCategorie(): Categorie{
        $categorie = (new Categorie())
                ->setName("CATEGORIE TEST");
        return $categorie;
    }
    
    /**
     * Test sur l'ajout d'une catégorie
     */
     public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategories + 1, $repository->count([]), "erreur lors de l'ajout");
    }

    /**
     * Test sur la suppression d'une catégorie
     */
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategories - 1, $repository->count([]), "erreur lors de la suppression");
    }

    /**
     * Test sur la méthode FindAllForOnePlaylist
     */
     public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $categories = $repository->findAllForOnePlaylist(3);
        $nbCategories = count($categories);
        $this->assertEquals(2, $nbCategories);
        $this->assertEquals("POO",$categories[0]->getName());
    }

    /**
     * Test sur la méthode FindAllOrderBy
     */
    public function testFindAllOrderBy(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $categories = $repository->findAllOrderBy("name", "ASC");
        $nbCategories = count($categories);
        $this->assertEquals(11, $nbCategories);
        $this->assertEquals("Android", $categories[0]->getName());
    }


}