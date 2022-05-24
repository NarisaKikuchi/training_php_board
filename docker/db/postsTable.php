<?php
require_once('usersTable.php');

class postsTable
{

    /**
     * 表示機能
     * 
     * @return void
     */
    public function display()
    {
        $dbconnect = new usersTable();
        $dbinfo = $dbconnect->connectDatabase();
        try {
            $sql = "SELECT * FROM posts order by seq_no asc;";
            $tabledata = $dbinfo->prepare($sql);
            $tabledata->execute();
            $result = $tabledata->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}