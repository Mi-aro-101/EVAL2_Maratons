<?php

namespace App\Service;

use App\Entity\EtapeCoureur;
use App\Entity\EtapeCourse;
use App\Entity\Equipe;
use App\Repository\CoureurRepository;
use App\Repository\EtapeCoureurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class EtapeCoureurService
{
    public function getClassementGeneral(EntityManagerInterface $entityManager, int $etape) : array
    {
        $query = "SELECT * FROM v_classement_generale WHERE etape=:idetape";
        $stmt = $entityManager->getConnection()->prepare($query);
        $resultSet = $stmt->executeQuery(['idetape' => $etape]);

        return $resultSet->fetchAllAssociative();
    }

    public function control(Request $request, EtapeCourse $etapeCourse, EtapeCoureurRepository $etapeCoureurRepository, Equipe $equipe)
    {
        $nbrCoureurRequis = $etapeCourse->getNbrCoureur();
        $coureursSelectiones = $request->request->all()['coureur'];
        // Check if there is already a coreur assigned to this
        $etapeCoureur = $etapeCoureurRepository->findCoureurIfCoureurDejaAssignee($coureursSelectiones, $etapeCourse->getId());
        if(count($etapeCoureur) > 0){
            throw new BadRequestException('Vous avez deja assigne ce/ces coureur pour cette etape');
        }

        $etapeCoureursInscrits = $etapeCoureurRepository->findCoureurByEquipeAndEtape($equipe, $etapeCourse);

        if(is_array($coureursSelectiones)){
            if(count($coureursSelectiones)+count($etapeCoureursInscrits) > $nbrCoureurRequis){
                throw new BadRequestException("Le nombre de coureur que vous avez selectionnees n'est pas valide pour cette etape");
            }
        }
        return;
    }

    public function flushAll(EtapeCourse $etapeCourse, EntityManagerInterface $entityManager, Request $request, CoureurRepository $coureurRepository)
    {
        $coureursSelectiones = $request->request->all()['coureur'];
        $coureurs = $coureurRepository->findWhereIn($coureursSelectiones);
        foreach($coureurs as $coureur){
            $etapeCoureurObj = new EtapeCoureur();
            $etapeCoureurObj->setEtapeCourse($etapeCourse);
            $etapeCoureurObj->setCoureur($coureur);
            $entityManager->persist($etapeCoureurObj);
        }

        $entityManager->flush();
    }
}