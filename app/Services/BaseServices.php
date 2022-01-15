<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

//Service
use App\Services\BlockServices;
use App\Services\BlockChainServices;

class BaseServices{

    public function block($request){
        $data = 1000;
        $previousHash = "0";
        $timestamp = date("Y-m-d h:i:s");
        $nonce = 0;
        $block = new BlockChainServices;
        return $block->createNewBlock($data, $previousHash, $timestamp, $nonce);
    }
}