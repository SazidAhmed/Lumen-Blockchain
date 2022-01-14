<?php

namespace App\Services;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BlockServices{

    public function calculateHash($index, $timestamp, $data, $previousHash){
        return hash('sha256', $index.$timestamp.$data.$previousHash);
    }

    public function blockStoreToDB($data, $previousHash, $hash){
        $newBlock = DB::table('blocks')->insert([
            'data' => $data,
            'previousHash' =>$previousHash,
            'hash' => $hash
        ]);

        return $newBlock;
    }

    public function createblock($id, $timestamp, $data, $previousHash){

        $hash = $this->calculateHash($id, $timestamp, $data, $previousHash);
        $newBlock = $this->blockStoreToDB($data, $previousHash, $hash);
        return $newBlock;
    }

    public function createGenesisBlock(){
        $id = 1;
        $timestamp = date("Y-m-d h:i:s");
        $data = 1000;
        $previousHash = "0";
        return $this->createblock($id, $timestamp, $data, $previousHash);
    }

    public function newBlock(){
        $data = $request->data();
    }

    public function blockchain($request){
        $chain = [];
        $blocks = DB::select("SELECT * FROM blocks");
        if($blocks){
            foreach($blocks as $block){
                if(!isset($chain[$block->id])){
                    array_push($chain, $block);
                }else{
                    continue;
                }
            }
            $this->newBlock($request);
        }else{
            $block = $this->createGenesisBlock();
        }
        return $chain;
    }

    public function getLatestBlock(){
        //
    }

    public function block($request){
       
        return $this->blockChain($request);
    }
}