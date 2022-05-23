<?php
require_once('../../db/usersTable.php');

class postsTable
{

    /**
     * 表示機能
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