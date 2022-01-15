<?php

namespace App\Services;

class BlockServices{
  public $data;
  public $previousHash;
  public $timestamp;
  public $hash;
  public $nonce;

  public function __construct($data, $previousHash, $timestamp, $nonce) {
    $this->data = $data;
    $this->previousHash = $previousHash;
    $this->timestamp = $timestamp;
    $this->hash = $this->calculateHash();
    $this->nonce = 0;
  }

  public function calculateHash(){
      return hash('sha256', $this->data.$this->previousHash.$this->timestamp.$this->nonce);
  }

  public function createblock(){
    $hash = $this->calculateHash();
    $newBlock = DB::table('blocks')->insert([
      'data' => $this->data,
      'previousHash' =>$this->previousHash,
      'hash' => $hash,
      'created_at' => $this->timestamp
    ]);
    return $newBlock;
  }

  public function mineBlock($difficulty){
    //
  }

}