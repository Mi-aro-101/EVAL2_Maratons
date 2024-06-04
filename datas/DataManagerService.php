<?php

namespace App\Service;

use App\Entity\DevisMirrorCsv;
use App\Entity\PaiementMirrorCsv;
use App\Entity\TypeMaisonMirrorCsv;
use Doctrine\ORM\EntityManagerInterface;

class DataManagerService
{

    public function insertPaiementMirror($file, EntityManagerInterface $entityManager)
    {
        $i = 0;
        while(!feof($file)){
            if($i == 0){
                $i+=1;
                fgets($file);
                continue;
            }
            $row = fgetcsv($file, 1000, ',');
            $paiementMirror = new PaiementMirrorCsv();
            $paiementMirror->setRefDevis($row[0]);
            $paiementMirror->setRefPaiement($row[1]);
            $paiementMirror->setDatePaiement($row[2]);
            $paiementMirror->setMontant($row[3]);
            $entityManager->persist($paiementMirror);
        }
        $entityManager->flush();
    }

    public function insertDevisMirror($file, EntityManagerInterface $entityManager)
    {
        $SPEC_CHAR = "/^\"(.*)\"$/";
        $i = 0;
        while(!feof($file)){
            if($i == 0){
                $i+=1;
                fgets($file);
                continue;
            }
            $row = fgetcsv($file, 1000, ',');
            $devisMirror = new DevisMirrorCsv();
            $devisMirror->setClient($row[0]);
            $devisMirror->setRefDevis($row[1]);
            $devisMirror->setTypeMaison($row[2]);
            $devisMirror->setFinition($row[3]);
            if (preg_match($SPEC_CHAR, $row[4], $matches)) {
                $devisMirror->setTauxFinition(str_replace('%', '', $matches[1]));
            } else {
                $devisMirror->setTauxFinition(str_replace('%', '', $row[4])); // Use the value as it is (including commas)
            }
            $devisMirror->setDateDevis($row[5]);
            $devisMirror->setDateDebut($row[6]);
            $devisMirror->setLieu($row[7]);
            $entityManager->persist($devisMirror);
        }
        $entityManager->flush();
    }

    public function insertTypeMaisonMirror($file, EntityManagerInterface $entityManager)
    {
        $SPEC_CHAR = "/^\"(.*)\"$/";
        $i = 0;
        while(!feof($file)){
            if($i == 0){
                $i+=1;
                fgets($file);
                continue;
            }
            $row = fgetcsv($file, 1000, ',');

            $typeMaisonMirror = new TypeMaisonMirrorCsv();
            $typeMaisonMirror->setTypeMaison($row[0]);
            if (preg_match($SPEC_CHAR, $row[1], $matches)) {
                $typeMaisonMirror->setDescription($matches[1]); // Extract the value within quotes
            } else {
                $typeMaisonMirror->setDescription($row[1]); // Use the value as it is (including commas)
            }
            $typeMaisonMirror->setSurface($row[2]);
            $typeMaisonMirror->setCodeTravaux($row[3]);
            $typeMaisonMirror->setTypeTravaux($row[4]);
            $typeMaisonMirror->setUnite($row[5]);
            if (preg_match($SPEC_CHAR, $row[6], $matches)) {
                $typeMaisonMirror->setPrixUnitaire($matches[1]);
            } else {
                $typeMaisonMirror->setPrixUnitaire($row[6]); // Use the value as it is (including commas)
            }
            if (preg_match($SPEC_CHAR, $row[7], $matches)) {
                $typeMaisonMirror->setQuantite($matches[1]);
            } else {
                $typeMaisonMirror->setQuantite($row[7]); // Use the value as it is (including commas)
            }
            $typeMaisonMirror->setDureeTravaux($row[8]);

            $entityManager->persist($typeMaisonMirror);
        }
        $entityManager->flush();
    }
}