<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ClassementService
{

    public function getVainqueurClassementGeneral(EntityManagerInterface $entityManager)
    {
        $sql = "WITH classement_winnner AS (
            SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe
                FROM classement cl, coureur c, equipe e
                WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
                GROUP BY e.id, e.nom_equipe, c.equipe_id
                ORDER BY score DESC
            )
            SELECT *
                FROM classement_winnner WHERE rang=1";

        $stmt = $entityManager->getConnection()->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function getClassementGeneral(EntityManagerInterface $entityManager) : array
    {
        $sql = "SELECT DENSE_RANK() OVER (ORDER BY (sum(point)) DESC) AS rang, sum(cl.point) as score, c.equipe_id, e.nom_equipe
                FROM classement cl, coureur c, equipe e
                WHERE c.id = cl.coureur_id AND c.equipe_id = e.id
                GROUP BY e.id, e.nom_equipe, c.equipe_id
                ORDER BY score DESC";
        $stmt = $entityManager->getConnection()->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function genererClassement(EntityManagerInterface $entityManager)
    {
        // First truncate the table
        $truncateQuery = "TRUNCATE TABLE classement";
        $entityManager->getConnection()->executeQuery($truncateQuery);
        // Then insert the new datas
        $sql = "INSERT INTO classement (id, coureur_id, etape_course_id, rang, point, genre, temps, penalite_temps, temps_final)
            SELECT nextval('classement_id_seq'), vcg.coureur_id, vcg.etape, vcg.rang, vcg.point
                , vcg.genre, vcg.temps, vcg.penalite_temps, vcg.temps_final
                FROM v_classement_generale2 vcg";
        $entityManager->getConnection()->executeQuery($sql);
    }

    public function getDetailsClassementParEtape(EntityManagerInterface $entityManager, $nomEquipe) : array
    {
        $sql = "SELECT sum(cl.point) as score, c.equipe_id, e.nom_equipe,
            cl.etape_course_id, ec.nom_etape
            FROM classement cl, coureur c, equipe e, etape_course ec
            WHERE c.id = cl.coureur_id AND c.equipe_id = e.id AND cl.etape_course_id = ec.id
            AND  e.nom_equipe = '%s'
            GROUP BY e.id, e.nom_equipe, c.equipe_id, cl.etape_course_id, ec.id
            ORDER BY score DESC";
            $sql = sprintf($sql, $nomEquipe);
        $stmt = $entityManager->getConnection()->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }
}