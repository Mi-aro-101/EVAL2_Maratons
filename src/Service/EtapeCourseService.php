<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\EtapeCourseMirror;
use Doctrine\ORM\EntityManagerInterface;

class EtapeCourseService
{

    public function getSeqValCourse($seqName, EntityManagerInterface $entityManager) : int
    {
        $sql = "SELECT last_value as seq_value FROM %s";
        $sql = sprintf($sql, $seqName);
        $stmt = $entityManager->getConnection()->executeQuery($sql);
        $result = $stmt->fetchAssociative();

        return (int) $result['seq_value'];
    }

    public function insertDatasFromMirror(EntityManagerInterface $entityManager)
    {
        $course = new Course();
        $course->setNomCourse('Course');
        $sql = "INSERT INTO etape_course (id, course_id, nbr_coureur, nom_etape, rang_etape, longueur, depart)
                SELECT nextval('etape_course_id_seq'), :idCourse, cast(ecm.nbr_coureur as integer)
                    , ecm.etape, cast(ecm.rang as integer), cast(ecm.longueur as double precision)
                    , TO_TIMESTAMP(CONCAT_WS(' ', ecm.date_depart, ecm.heure_depart), 'dd/MM/YYYY HH24:MI:ss')::timestamp
                FROM etape_course_mirror ecm;";

        $entityManager->persist($course);
        $entityManager->flush();

        $idCourse = $this->getSeqValCourse('course_id_seq', $entityManager);
        try {

            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->executeQuery(['idCourse' => $idCourse]);

        } catch (\Throwable $th) {
            $entityManager->remove($course);
            $entityManager->flush();
            throw $th;
        }

    }

    /**
     * Get the datas from csv and insert into the mirror table
     */
    public function etapeFromFile($file, EntityManagerInterface $entityManager)
    {
        $SPEC_CHAR = "/^\"(.*)\"$/";
        $i = 0;
        while(!feof($file)){
            if($i==0){
                $i++;
                fgets($file);
                continue;
            }
            $row = fgetcsv($file, 1000, ',');
            $etapeCourseMirror = new EtapeCourseMirror();
            $etapeCourseMirror->setEtape($row[0]);
            if (preg_match($SPEC_CHAR, $row[1], $matches)) {
                $value = str_replace('%', '', $matches[1]);
                $etapeCourseMirror->setLongueur(str_replace(',', '.', $value));
            } else {
                $value = str_replace('%', '', $row[1]);
                $etapeCourseMirror->setLongueur(str_replace(',', '.', $value));
            }
            $etapeCourseMirror->setNbrCoureur($row[2]);
            $etapeCourseMirror->setRang($row[3]);
            $etapeCourseMirror->setDateDepart($row[4]);
            $etapeCourseMirror->setHeureDepart($row[5]);

            $entityManager->persist($etapeCourseMirror);
        }

        $entityManager->flush();

    }
}