<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//Service
use App\Services\BaseServices;

class BlockController extends Controller
{
    private $baseServices;

    public function __construct(BaseServices $baseServices){
        $this->services = $baseServices;
    }

    public function block(Request $request){
        return $this->services->block($request);
    }
}
