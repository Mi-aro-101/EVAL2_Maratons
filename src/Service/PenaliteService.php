<?php

namespace App\Service;

use App\Entity\Penalite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class PenaliteService
{

    public function manageThenFormat($heure, $minute, $seconde)
    {
        $message = [];
        if($heure == null){
            array_push($message, "Le champ 'heure' est obligatoire");
        }
        if($minute == null){
            array_push($message, "Le champ 'minute' est obligatoire");
        }
        if($seconde == null){
            array_push($message, "Le champ 'seconde' est obligatoire");
        }

        if(count($message) > 0){
            $bigmessage = '';
            foreach($message as $mess){
                $bigmessage .= $mess. " ! ";
            }
            throw new BadRequestException($bigmessage);
        }

        if(strlen($heure) == 1) $heure = '0'.$heure;
        if(strlen($minute) == 1) $minute = '0'.$minute;
        if(strlen($seconde) == 1) $seconde = '0'.$seconde;

        $result = $heure.':'.$minute.':'.$seconde;
        return $result;
    }
    public function insertPenalite(Penalite $penalite, Request $request, EntityManagerInterface $entityManager)
    {
        $heure = $request->request->get('heure');
        $minute = $request->request->get('minute');
        $seconde = $request->request->get('seconde');
        $equipe = $penalite->getEquipe();
        $etapeCourse = $penalite->getEtapeCourse();

        $time = $this->manageThenFormat($heure, $minute, $seconde);

        $query = "INSERT INTO penalite (id, etape_course_id, equipe_id, temps) VALUES
            (nextval('penalite_id_seq'), %s, %s, '%s')";
        $query = sprintf($query, $etapeCourse->getId(), $equipe->getId(), $time);

        $stmt = $entityManager->getConnection()->prepare($query);
        $stmt->executeQuery();
    }
}