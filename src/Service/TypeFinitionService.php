<?php

namespace App\Service;

class TypeFinitionService
{
    public function getChartColor()
    {
        $results = array();
        array_push($results, 'bg-amber');
        array_push($results, 'bg-red');
        array_push($results, 'bg-indigo');
        array_push($results, 'bg-light-green');
        array_push($results, 'bg-light-blue');
        array_push($results, 'bg-pink');
        array_push($results, 'bg-blue-grey');
        array_push($results, 'bg-orange');
        array_push($results, 'bg-green');
        array_push($results, 'bg-cyan');

        return $results;
    }

    public function assignColor($typeFinition)
    {
        $result = array();
        $colors = $this->getChartColor();
        $j = 0;
        for($i = 0 ; $i < count($typeFinition) ; $i++){
            $result[$typeFinition[$i]->getId()] = [$typeFinition[$i], $colors[$j]];
            $j+=1;
            if($j == count($colors)-1){
                $j = 0;
            }
        }
        return $result;
    }
}