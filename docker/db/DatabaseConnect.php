<?php

class DatabaseConnect
{
    /**
     * DB接続
     * 
     * @return mixed $db_info
     */
    public function connectDatabase()
    {
        $db_name = 'pgsql:dbname=board_database; host=db; port=5555;';
        $db_password = 'password';
        $user_name = 'root';
        $db_info = new PDO($db_name, $user_name, $db_password);
        return $db_info;
    }
}