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
     * 追加投稿表示機能
     * 
     * @return void
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
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 投稿削除機能
     * 
     * @return void
     */
    public function deletePostDatabese()
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

    /**
     * 一括削除機能
     * 
     * @return void
     */
    public function deleteBulkPostDatabase()
    {
        $dbconnect = new usersTable();
        $dbinfo = $dbconnect->connectDatabase();
        try {
            $deletechecked = $_POST['deleteChecked'];
            $sql = "DELETE FROM posts WHERE seq_no = :number;";
            $checkedpostdata = $dbinfo->prepare($sql);
            // foreachで削除するレコードを1件ずつループ処理
            foreach ($deletechecked as $value) {
                // 配列の値を :id にセットし、executeでSQLを実行
                $checkedpostdata->execute(array(':number' => $value));
            }
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 投稿内容の更新
     * 
     * @return void
     */
    public function updatePostDataBySeqNo()
    {
        $dbconnect = new usersTable();
        $dbinfo = $dbconnect->connectDatabase();
        try {
            $edittitle = $_POST['postTitle'];
            $editcontents = $_POST['postContents'];
            $edit = $_POST['editButton'];
            $date = new DateTime();
            $currentdate = $date->format('Y/m/d');
            $sql = 'UPDATE posts set post_date = :postdate, post_title = :posttitle, post_contents = :postcontents where seq_no = :number;';
            $editpostdata = $dbinfo->prepare($sql);
            $editpostdata->bindValue(':postdate', $currentdate);
            $editpostdata->bindValue(':posttitle', $edittitle);
            $editpostdata->bindValue(':postcontents', $editcontents);
            $editpostdata->bindValue(':number', $edit);
            $editpostdata->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}