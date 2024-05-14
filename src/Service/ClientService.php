<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ClientService
{

    public function formatTelephone($telephone)
    {
        $telephone = trim($telephone);
        $telephone = str_replace(' ', '', $telephone);
        return $telephone;
    }

    public function checkFormat($telephone)
    {
        $TEL_REF = ['2', '3'];
        $OPERATEUR_REF = ['2', '3', '4', '7', '8'];
        $errors = array();
        $first = $telephone[0];
        $second = $telephone[1];
        $third = $telephone[2];
        if(strlen($telephone) != 10)
            array_push($errors, "La longueur du numero n'est pas valide");
        if($first != 0)
            array_push($errors, 'Le numero doit commencer par 0');
        if(!in_array($second, $TEL_REF))
            array_push($errors, 'Le second chiffre doit etre 2 ou 3');
        if(!in_array($third, $OPERATEUR_REF))
            array_push($errors, 'La troisieme chiffre ne correspond pas a un id operateur de Madagascar');

        if(count($errors) > 0){
            throw new Exception($this->concatenateErrors($errors));
        }
    }

    public function concatenateErrors($errors) : string
    {
        $result = '';
        foreach($errors as $error) {
            $result .= $error.' </br> ';
        }

        return $result;
    }

    public function userExist($telephone, ClientRepository $clientRepository)
    {
        $result = false;
        $client = $clientRepository->findBy([ 'telephone'=> $telephone ]);
        if(count($client) > 0)
            $result = true;
        return $result;
    }

    public function newUser($telephone, EntityManagerInterface $entityManager)
    {
        $client = new Client();
        $client->setTelephone($telephone);
        $client->setRoles(["ROLE_USER"]);
        $entityManager->persist($client);
        $entityManager->flush();
    }
}