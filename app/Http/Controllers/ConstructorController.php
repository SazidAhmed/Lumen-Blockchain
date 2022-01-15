<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//Service
use App\Services\BlockServices;

class ConstructorController extends Controller{

    public function construct(Request $request){
        $apple = new BlockServices(1000, "0", "22/01/15", 5);
        echo $apple->calculateHash();
    }
}
