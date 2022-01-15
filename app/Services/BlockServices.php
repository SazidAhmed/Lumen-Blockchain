<?php

namespace App\Services;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BlockServices{

    public function calculateHash($data, $previousHash, $timestamp){
        return hash('sha256', $timestamp.$data.$previousHash);
    }

    public function blockStoreToDB($data, $previousHash, $hash, $timestamp){
        $newBlock = DB::table('blocks')->insert([
            'data' => $data,
            'previousHash' =>$previousHash,
            'hash' => $hash,
            'created_at' => $timestamp
        ]);
        return $newBlock;
    }

    public function createblock($data, $previousHash, $timestamp){
        $hash = $this->calculateHash($data, $previousHash, $timestamp);
        return $this->blockStoreToDB($data, $previousHash, $hash, $timestamp);
    }

    public function createGenesisBlock(){
        $timestamp = date("Y-m-d h:i:s");
        $data = 1000;
        $previousHash = "0";
        return $this->createblock($data, $previousHash, $timestamp);
    }

    public function newBlock($request){
        $blocks = DB::table("blocks")->orderBy("id",'desc')->paginate(2);
        $previousHash = $blocks[0]->hash;
        $data = $request->data;
        $timestamp = date("Y-m-d h:i:s");
        $this->createblock($data, $previousHash, $timestamp);
    }

    public function blockchain($request){
        $chain = [];
        $blockCount = DB::table("blocks")->count();
        if($blockCount > 0){
            $this->newBlock($request);
            $blocks = DB::table("blocks")->get();
            foreach($blocks as $block){
                if(!isset($chain[$block->id])){
                    array_push($chain, $block);
                }else{
                    continue;
                }
            }
        }else{
            $block = $this->createGenesisBlock();
        }
        return $chain;
    }

    public function isChainValid(){
        $blocks = DB::table("blocks")->orderBy('id', 'desc')->get();
        $count = count($blocks);
        for($i = 1; $i<$count; $i++){
            //check current block hash
            $currentBlockHash = $blocks[$i-1]->hash;
            $currentBlockData = $blocks[$i-1]->data;
            $currentBlockPreviousHash = $blocks[$i-1]->previousHash;
            $currentBlockTimestamp = $blocks[$i-1]->created_at;
            $currentBlockCalcualteHash = $this->calculateHash($currentBlockData, $currentBlockPreviousHash, $currentBlockTimestamp);
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

    public function block($request){
        return $this->blockChain($request);
    }
}