<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

//Service
use App\Services\HashServices;

class BlockServices{
  public $data;
  public $previousHash;
  public $timestamp;
  public $hash;
  public $nonce;

  public function __construct($data, $previousHash, $timestamp) {
    $this->data = $data;
    $this->previousHash = $previousHash;
    $this->timestamp = $timestamp;
    $this->nonce = 0;
    $this->hash = $this->calculateHash();
  }

  public function calculateHash(){
    return hash('sha256', $this->data.$this->previousHash.$this->timestamp.$this->nonce);
  }

  public function createblock(){
    $newBlock = DB::table('blocks')->insert([
      'data' => $this->data,
      'previousHash' =>$this->previousHash,
      'hash' => $this->hash,
      'created_at' => $this->timestamp
    ]);
    return $newBlock;
  }

  public function mineBlock($difficulty){
    return $this->hash.substr(0,$difficulty);
    // while($this->hash.substr(0,$difficulty) !== join("0", array($difficulty + 1))){
    //   $this->nonce++;
    //   $this->hash = $this->calculateHash();
    // }
    // echo $this->hash;
  }

}