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

    /**
     * 追加投稿の表示機能
     * 
     * @return void
     */
    public function addDisplay()
    {
        $dbconnect = new usersTable();
        $dbinfo = $dbconnect->connectDatabase();
        try {
            $sql = "select * from posts where seq_no=(select max(seq_no) from posts);";
            $tabledata = $dbinfo->prepare($sql);
            $tabledata->execute();
            $result = $tabledata->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 追加投稿表示機能
     * 
     */
    public function addPostDisplay()
    {
        $dbconnect = new usersTable();
        $dbinfo = $dbconnect->connectDatabase();
        try {
            $title = $_POST['postTitle'];
            $contents = $_POST['postContents'];
            $date = new DateTime();
            $currentdate = $date->format('Y/m/d');
            $sql = 'INSERT INTO posts (post_date, user_id, post_title, post_contents) VALUES (:postdate, :loginuserid, :posttitle, :postcontents)';
            $addpostdata = $dbinfo->prepare($sql);
            $addpostdata->bindValue(':postdate', $currentdate);
            $addpostdata->bindValue(':loginuserid', $_SESSION['loginuserid']);
            $addpostdata->bindValue(':posttitle', $title);
            $addpostdata->bindValue(':postcontents', $contents);
            $addpostdata->execute();
            error_log($_POST['postTitle'] . $_POST['postContents']);
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}