<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

use App\Services\BlockServices;
use App\Services\BlockChainServices;
use App\Services\ValidationServices;

class BaseServices{

    public function block($request){
        $block = new BlockServices(1000000, '0', '2022-01-17 12:26:46');
        $difficulty = 2;
        return $block->mineBlock($difficulty);
        return ValidationServices::isChainValid();
        $block = new BlockChainServices;
        return $block->blockChain($request);
    }
}