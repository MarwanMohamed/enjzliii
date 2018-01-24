<?php
namespace App\Services;

class Encrypt {

    // Generate Random Digit
    function genRndDgt($length = 8, $specialCharacters = true) {
        $digits = '';
        $chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";

        if($specialCharacters === true)
            $chars .= "!?=/&+,.";


        for($i = 0; $i < $length; $i++) {
            $x = mt_rand(0, strlen($chars) -1);
            $digits .= $chars{$x};
        }

        return $digits;
    }

    // Generate Random Salt for Password encryption
    function genRndSalt() {
        return $this->genRndDgt(8, true);
    }

    // Encrypt User Password
    function encryptUserPwd($pwd, $salt) {
        return sha1(md5($pwd) . $salt);
    }
    
    // Generate Random Password
    function get_random_password($chars_min=6, $chars_max=16, $use_upper_case=false, $include_numbers=false, $include_special_chars=false){
        
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                

      return $password;
    }
}
