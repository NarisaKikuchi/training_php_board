<?php
session_start();

require_once('DatabaseConnect.php');

class PostsTable
{
    /**
     * レコードを全て取得
     * 
     * @return void
     */
    public function getPostDataWithAscendingOrder()
    {
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $sql = "SELECT * FROM posts order by seq_no asc;";
            $table_data = $db_info->prepare($sql);
            $table_data->execute();
            $result = $table_data->fetchAll();
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
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $title = $_POST['postTitle'];
            $contents = $_POST['postContents'];
            $date = new DateTime();
            $current_date = $date->format('Y/m/d');
            $sql = 'INSERT INTO posts (post_date, user_id, post_title, post_contents) VALUES (:postdate, :loginuserid, :posttitle, :postcontents)';
            $add_post_data = $db_info->prepare($sql);
            $add_post_data->bindValue(':postdate', $current_date);
            $add_post_data->bindValue(':loginuserid', $_SESSION['loginUserId']);
            $add_post_data->bindValue(':posttitle', $title);
            $add_post_data->bindValue(':postcontents', $contents);
            $add_post_data->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * データベースから投稿を削除
     * 
     * @return void
     */
    public function deletePostDataBySeqNo()
    {
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $delete = $_POST['deleteButton'];
            $sql = "DELETE FROM posts WHERE seq_no = :number;";
            $delete_post_data = $db_info->prepare($sql);
            $delete_post_data->bindValue(':number', $delete);
            $delete_post_data->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 一括削除機能
     * 
     * @return void
     */
    public function deleteBulkPostData()
    {
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $delete_checked = $_POST['deleteChecked'];
            $sql = "DELETE FROM posts WHERE seq_no = :number;";
            $checked_post_data = $db_info->prepare($sql);
            // foreachで削除するレコードを1件ずつループ処理
            foreach ($delete_checked as $value) {
                // 配列の値を :id にセットし、executeでSQLを実行
                $checked_post_data->execute(array(':number' => $value));
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
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $edit_title = $_POST['postTitle'];
            $editcontents = $_POST['postContents'];
            $edit = $_POST['editButton'];
            $date = new DateTime();
            $current_date = $date->format('Y/m/d');
            $sql = 'UPDATE posts set post_date = :postdate, post_title = :posttitle, post_contents = :postcontents where seq_no = :number;';
            $edit_post_data = $db_info->prepare($sql);
            $edit_post_data->bindValue(':postdate', $current_date);
            $edit_post_data->bindValue(':posttitle', $edit_title);
            $edit_post_data->bindValue(':postcontents', $editcontents);
            $edit_post_data->bindValue(':number', $edit);
            $edit_post_data->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 昇順機能
     * 
     * @return void
     */
    public function getPostDataWithAscendingOrderByDate()
    {
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $sql = "SELECT * FROM posts order by post_date asc;";
            $asc_date = $db_info->prepare($sql);
            $asc_date->execute();
            $result = $asc_date->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 昇順機能
     * 
     * @return void
     */
    public function getPostDataWithDescendingOrderByDate()
    {
        $db_connect = new DatabaseConnect();
        $db_info = $db_connect->connectDatabase();
        try {
            $sql = "SELECT * FROM posts order by post_date desc;";
            $desc_date = $db_info->prepare($sql);
            $desc_date->execute();
            $result = $desc_date->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}