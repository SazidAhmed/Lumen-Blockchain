<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

//Service
use App\Services\BlockServices;

class BlockChainServices{

    public $chain;
    public function createGenesisBlock(){
        $data = 1000000;
        $previousHash = "0";
        $timestamp = date("Y-m-d h:i:s");
        $nonce = 0;
        $genesisBlock = new BlockServices($data, $previousHash, $timestamp, $nonce);
        return $genesisBlock->createblock();
    }

    public function createNewBlock($request){
        $blocks = DB::table("blocks")->orderBy("id",'desc')->paginate(1);
        $previousHash = $blocks[0]->hash;
        $data = $request->data;
        $timestamp = date("Y-m-d h:i:s");
        $nonce = 0;
        $block = new BlockServices($data, $previousHash, $timestamp, $nonce);
        return $block->createblock();
    }

    public function blockChain($request){
        $chain = [];
        $blockCount = DB::table("blocks")->count();
        if($blockCount > 0){
            $this->createNewBlock($request);
        }else{
            $this->createGenesisBlock();
        }
        $blocks = DB::table("blocks")->get();
        foreach($blocks as $block){
            if(!isset($chain[$block->id])){
                array_push($chain, $block);
            }else{
                continue;
            }
        }
        return $chain;
    }

    public function getLatestBlock($request){
        $chain = $this->blockChain($request);
        $latest = $chain[count($chain)-1];
        return $latest;
    }

    public function getChain(){
        $this->createGenesisBlock();
        return $this->chain;
    }
}