<?php

    $db_name = 'mysql:host=localhost;dbname=home_db';
    $db_user_name ='root';
    $db_user_pass ='';

    $conn = new PDO($db_name, $db_user_name, $db_user_pass);

    function create_unique_id(){
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //62 characters 
        $char_len = strlen($char);
        $rand_str = ''; // random string
        for($i = 0; $i < 20; $i++){
            $rand_str .= $char[mt_rand(0,$char_len - 1)];  // the dot joins the strings together.
        }                                    //mt_rand generates random numbers ---> mt_rand(min,max)

        return $rand_str;
        
    }
?>