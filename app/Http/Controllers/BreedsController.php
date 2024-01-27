<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;

class BreedsController extends Controller
{
    public function getBreeds()
    {
        $listOfDogs =  Http::get("https://dog.ceo/api/breeds/list/all");
        $data = $listOfDogs["message"];
        $dogList = array();
        $newDogList = array();
        $id = 1;
        $image = "";


        foreach ($data as $key => $value) {
            $dog = array("breed" => $key);
            $dogObj = (object)$dog;
            $dogList[] = $dogObj;
        }

        $randomBreed = array_rand($dogList, 4);

        $numero_aleatorio = rand(1, 4);

        foreach ($randomBreed as $i) {
            $dogList[$i]->id = $id;
            if ($id == $numero_aleatorio) {
                $dogList[$i]->correct = true;
            } else {
                $dogList[$i]->correct = false;
            }
            $id++;
            $newDogList[] = ($dogList[$i]);
        }

        foreach ($newDogList as $i) {
            if ($i->{"correct"}) {
                $breedName = $i->{"breed"};
                $resImageDog = Http::get("https://dog.ceo/api/breed/" . $breedName . "/images/random");
                $image = $resImageDog["message"];
            }
        }

        $res = array("image" => $image, "options" => $newDogList);
        $resObj = (object)$res;
        return $resObj;
    }
}
