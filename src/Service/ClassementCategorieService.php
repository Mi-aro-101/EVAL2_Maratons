<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ClassementCategorieService
{

    public function getVainqueurByCategorie($categorieid, EntityManagerInterface $entityManager)
    {
        $sql = "WITH classement_cat AS (
            SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe, cl.categorie_coureur_id
                        FROM classement_categorie cl, coureur c, equipe e
                        WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
                        GROUP BY e.id, e.nom_equipe, c.equipe_id, cl.categorie_coureur_id
                        ORDER BY rang, score DESC
            )
            SELECT *
                FROM classement_cat WHERE rang = 1 AND categorie_coureur_id = %s";
        $sql = sprintf($sql, $categorieid);
        $stmt = $entityManager->getConnection()->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getClassementEquipeByCategorie(EntityManagerInterface $entityManager, $categorieid) : array
    {
        $sql = "SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe, cl.categorie_coureur_id
            FROM classement_categorie cl, coureur c, equipe e
            WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
            AND cl.categorie_coureur_id = %s
            GROUP BY e.id, e.nom_equipe, c.equipe_id, cl.categorie_coureur_id
            ORDER BY rang, score DESC";
        $sql = sprintf($sql, $categorieid);
        $stmt = $entityManager->getConnection()->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    /**
     * 
     */
    public function genererClassementCategorie(EntityManagerInterface $entityManager)
    {
        $truncateSql = "TRUNCATE TABLE classement_categorie";
        $entityManager->getConnection()->executeQuery($truncateSql);

        $sql = "INSERT INTO classement_categorie (id, coureur_id, etape_course_id, categorie_coureur_id, rang, point, genre, temps, penalite_temps, temps_final)
            SELECT nextval('classement_categorie_id_seq'), vcc.coureur_id, vcc.etape, vcc.categorie_coureur_id, vcc.rang, vcc.point,
                vcc.genre, vcc.temps, vcc.penalite_temps, vcc.temps_final
                FROM v_classement_categorie2 vcc";
        $entityManager->getConnection()->executeQuery($sql);
    }
}