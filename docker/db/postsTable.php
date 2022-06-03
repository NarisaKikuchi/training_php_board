<?php
require_once('usersTable.php');

class postsTable
{

    /**
     * レコードを全て取得
     * 
     * @return void
     */
    public function getPostDataWithAscendingOrder()
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
     * seq_noが最大のレコードを取得
     * 
     * @return void
     */
    public function getPostWhereMaxSeqNo()
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
     * 追加投稿をデータベースに挿入
     * 
     * @return void
     */
    public function insertPostData()
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
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * データベースから投稿を削除
     * 
     * @return void
     */
    public function deletePostData()
    {
        $dbconnect = new usersTable();
        $dbinfo = $dbconnect->connectDatabase();
        try {
            $delete = $_POST['deleteButton'];
            $sql = "DELETE FROM posts WHERE seq_no = :number;";
            $deletepostdata = $dbinfo->prepare($sql);
            $deletepostdata->bindValue(':number', $delete);
            $deletepostdata->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}