<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//Service
use App\Services\BlockServices;

class BlockController extends Controller
{
    private $blockServices;

    public function __construct(BlockServices $blockServices){
        $this->services = $blockServices;
    }

    public function block(Request $request){
        return $this->services->block($request);
    }
}
