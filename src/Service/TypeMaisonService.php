<?php

namespace App\Service;

class TypeMaisonService
{
    public function getCardColor()
    {
        $results = array();
        array_push($results, 'header bg-red');
        array_push($results, 'header bg-amber');
        array_push($results, 'header bg-light-green');
        array_push($results, 'header bg-light-blue');
        array_push($results, 'header bg-pink');
        array_push($results, 'header bg-blue-grey');
        array_push($results, 'header bg-orange');
        array_push($results, 'header bg-green');
        array_push($results, 'header bg-cyan');

        return $results;
    }

    public function assignColor($typeMaison)
    {
        $result = array();
        $colors = $this->getCardColor();
        $j = 0;
        for($i = 0 ; $i < count($typeMaison) ; $i++){
            $result[$typeMaison[$i]->getId()] = [$typeMaison[$i], $colors[$j]];
            $j+=1;
            if($j == count($colors)-1){
                $j = 0;
            }
        }
        return $result;
    }
}