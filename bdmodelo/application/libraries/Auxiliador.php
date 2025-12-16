<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auxiliador{
    public function verificaID($id){
        if(!ctype_digit($id) or $id == 0){
            return true;
        }else{
            return false;
        }
    }
}