<?php

namespace App\Service;

use App\Entity\CategorieCoureur;
use App\Repository\CategorieCoureurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class CategorieCoureurService
{

    public function generate(EntityManagerInterface $entityManager, CategorieCoureurRepository $categorieCoureurRepository)
    {
        $this->generateCategorie($entityManager);
        $this->assignCategorieCoureur($entityManager, $categorieCoureurRepository);
    }

    public function fetchCoureurAlongAge(EntityManagerInterface $entityManager) : array
    {
        $sql = "SELECT (2024 - extract(year from c.date_de_naissance)) as age, c.nom_coureur, c.id, c.genre
            FROM Coureur c";
        $stmt = $entityManager->getConnection()->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function assignCategorieCoureur(EntityManagerInterface $entityManager, CategorieCoureurRepository $categorieCoureurRepository)
    {
        $coureurs = $this->fetchCoureurAlongAge($entityManager);
        $queries = [];
        foreach($coureurs as $coureur){
            if($coureur['age'] < 18){
                $categorie = $categorieCoureurRepository->findByNomCategorie('Junior')[0];
                $categorieid = $categorie->getId();
                $query = $this->generateSqlsFrom($coureur['id'], $categorieid);
                array_push($queries, $query);
            }
            if($coureur['genre'] == 'F'){
                $categorie = $categorieCoureurRepository->findByNomCategorie('femme')[0];
                $categorieid = $categorie->getId();
                $query = $this->generateSqlsFrom($coureur['id'], $categorieid);
                array_push($queries, $query);
            }
            else if($coureur['genre'] = 'M'){
                $categorie = $categorieCoureurRepository->findByNomCategorie('homme')[0];
                $categorieid = $categorie->getId();
                $query = $this->generateSqlsFrom($coureur['id'], $categorieid);
                array_push($queries, $query);
            }
        }
        $this->execute($entityManager, $queries);
    }

    public function execute(EntityManagerInterface $entityManager, array $queries)
    {
        try{
            $entityManager->getConnection()->beginTransaction();
                foreach($queries as $query){
                    $stmt = $entityManager->getConnection()->prepare($query);
                    $stmt->executeQuery();
                }
                $entityManager->getConnection()->commit();
        }catch(\Exception $e){
            $entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function generateSqlsFrom($coureurid, $categorieid) : string
    {
        $sql = "INSERT INTO coureur_categorie_coureur (coureur_id, categorie_coureur_id) VALUES (%s, %s)";
        $sql = sprintf($sql, $coureurid, $categorieid);
        return $sql;
    }

    /**
     * Generate new categories
     */
    public function generateCategorie(EntityManagerInterface $entityManager)
    {
        $CATEGORIES = new ArrayCollection();
        $categorie1 = new CategorieCoureur();
        $categorie1->setNomCategorie('Junior');
        $CATEGORIES->add($categorie1);
        $categorie2 = new CategorieCoureur();
        $categorie2->setNomCategorie('homme');
        $CATEGORIES->add($categorie2);
        $categorie3 = new CategorieCoureur();
        $categorie3->setNomCategorie('femme');
        $CATEGORIES->add($categorie3);

        foreach($CATEGORIES as $categorie){
            $entityManager->persist($categorie);
        }

        $entityManager->flush();
    }
}