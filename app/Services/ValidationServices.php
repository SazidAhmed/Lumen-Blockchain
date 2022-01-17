<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

//Service
use App\Services\BlockServices;

class ValidationServices{

    public static function isChainValid(){
        $blocks = DB::table("blocks")->orderBy('id', 'desc')->get();
        $count = count($blocks);
        
        for($i = 1; $i<=$count; $i++){
            //check current block hash
            $currentBlockHash = $blocks[$i-1]->hash;
            $currentBlockData = $blocks[$i-1]->data;
            $currentBlockPreviousHash = $blocks[$i-1]->previousHash;
            $currentBlockTimestamp = $blocks[$i-1]->created_at;
            $blockService = new BlockServices($currentBlockData, $currentBlockPreviousHash, $currentBlockTimestamp);

            $currentBlockCalcualteHash = $blockService->calculateHash();
            return $currentBlockCalcualteHash;
            if($currentBlockHash !== $currentBlockCalcualteHash){
                return false;
            }
            //check previous block hash
            $prevBlockHash = $blocks[$i]->hash;
            if($currentBlockPreviousHash !== $prevBlockHash){
                return false;
            }
            return true;
        }
    }
}