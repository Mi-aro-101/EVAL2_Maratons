<?php

namespace App\Service;

use App\Entity\Resultat;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResultatService
{
    public function insertMirror($file, EntityManagerInterface $entityManager)
    {
        $i= 0;
        while(!feof($file)){
            if($i==0){
                $i++;
                fgets($file);
                continue;
            }
            $row = fgetcsv($file, 1000, ',');
            $resultat = new Resultat();
            $resultat->setEtapeRang($row[0]);
            $resultat->setNumeroDossard($row[1]);
            $resultat->setNom($row[2]);
            $resultat->setGenre($row[3]);
            $resultat->setDateNaissance($row[4]);
            $resultat->setEquipe($row[5]);
            $resultat->setArrivee($row[6]);

            $entityManager->persist($resultat);
        }
        $entityManager->flush();
    }

    /**
     * Insertino des Utilisateurs depuis mirror
     */
    public function insertUtilisateur(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $connection = $entityManager->getConnection();
        $sql = 'SELECT distinct r.equipe FROM Resultat r';
        $stmt = $connection->executeQuery($sql);
        $result = $stmt->fetchAllAssociative();
        foreach($result as $email){
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($email['equipe']);
            $utilisateur->setRoles(['ROLE_TEAM']);
            $utilisateur->setPassword(
                $hasher->hashPassword($utilisateur, $email['equipe'])
            );
            $entityManager->persist($utilisateur);
        }

        $entityManager->flush();
    }

    /**
     * Insertion equipe depuis mirror
     */
    public function insertEquipe(EntityManagerInterface $entityManager)
    {
        $query = "INSERT INTO equipe (nom_equipe, id, utilisateur_id)
            WITH equipe AS ( SELECT DISTINCT r.equipe as eq FROM Resultat r)
            SELECT eq, nextval('equipe_id_seq'), u.id
                FROM equipe e, Utilisateur u WHERE u.email=e.eq";
        $entityManager->getConnection()->executeQuery($query);
    }

    public function insertCoureur(EntityManagerInterface $entityManager)
    {
        $query = "INSERT INTO coureur (id, nom_coureur, numero_dossard, date_de_naissance, equipe_id, genre)
            WITH Resultat_m AS (
                SELECT distinct r.nom, r.numero_dossard,
                        TO_DATE(r.date_naissance, 'dd/MM/yyyy') datedenaissance, r.equipe, r.genre
                    FROM Resultat r
            )
            SELECT nextval('coureur_id_seq'), rm.nom, rm.numero_dossard, rm.datedenaissance, e.id, rm.genre
                FROM Resultat_m rm, equipe e WHERE e.nom_equipe = rm.equipe";
        $entityManager->getConnection()->executeQuery($query);
    }

    public function insertEtapeCoureur(EntityManagerInterface $entityManager)
    {
        $query = "INSERT INTO etape_coureur (id, coureur_id, etape_course_id, arrivee)
            SELECT nextval('etape_coureur_id_seq'), c.id, ec.id,
                TO_TIMESTAMP(r.arrivee, 'dd/MM/yyyy HH24:MI:ss')::timestamp
                FROM Resultat r, coureur c, etape_course ec
                WHERE r.nom=c.nom_coureur AND cast(r.etape_rang as integer)=ec.rang_etape";

        $entityManager->getConnection()->executeQuery($query);
    }

    public function manageAll($file, $entityManager, UserPasswordHasherInterface $hasher)
    {
        // Inserting mirror
        $this->insertMirror($file, $entityManager);
        $this->insertUtilisateur($entityManager, $hasher);
        $this->insertEquipe($entityManager);
        $this->insertCoureur($entityManager);
        $this->insertEtapeCoureur($entityManager);
    }
}