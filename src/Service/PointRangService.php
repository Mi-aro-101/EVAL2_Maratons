<?php

namespace App\Service;

use App\Entity\PointRangMirror;
use App\Repository\EtapeCourseRepository;
use Doctrine\ORM\EntityManagerInterface;

class PointRangService
{
    public function insertDataFromMirrors(EntityManagerInterface $entityManager, EtapeCourseRepository $etapeCourseRepository)
    {
        $etapes = $etapeCourseRepository->findAll();
        $connection = $entityManager->getConnection();
        // $connection->beginTransaction();
        try{
            foreach ($etapes as $etape) {
                $query = "INSERT INTO point_rang (id, etape_course_id, point, rang)
                    SELECT nextval('point_rang_id_seq'), %s, cast(rpm.points as double precision), cast(rpm.classement as integer)
                    FROM point_rang_mirror rpm";
                $query = sprintf($query, $etape->getId());
                $connection->executeQuery($query);
                // $connection->commit();
            }
        }catch(\Exception $e){
            // $connection->rollBack();
            throw $e;
        }
    }

    /**
     * Get the datas from csv and insert into the mirror table
     */
    public function pointFromFile($file, EntityManagerInterface $entityManager)
    {
        $i = 0;
        while(!feof($file)){
            if($i==0){
                $i++;
                fgets($file);
                continue;
            }
            $row = fgetcsv($file, 1000, ',');
            $pointRangMirror = new PointRangMirror();
            $pointRangMirror->setClassement($row[0]);
            $pointRangMirror->setPoints($row[1]);

            $entityManager->persist($pointRangMirror);
        }

        $entityManager->flush();
    }
}