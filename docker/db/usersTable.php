<?php
session_start();

class usersTable
{
    /**
     * DB接続
     * 
     * @return mixed $dbinfo
     */
    public function connectDatabase()
    {
        $dbname = 'pgsql:dbname=board_database; host=db; port=5555;';
        $dbpassword = 'password';
        $username = 'root';
        $dbinfo = new PDO($dbname, $username, $dbpassword);
        return $dbinfo;
    }

    /**
     * ユーザー情報新規登録
     * 
     * @param String $userid, ユーザーID
     * @param String $password, パスワード
     * @return void
     */
    public function userRegist($userid, $password)
    {

        try {
            $dbconnect = $this->connectDatabase();
            $sql = "SELECT * FROM users WHERE user_id = :userId;";
            $stmt = $dbconnect->prepare($sql);
            $stmt->bindValue(':userId', $userid);
            $stmt->execute();
            $users = $stmt->fetchAll();
            foreach ($users as $user) {
                if ($user['user_id']) {
                    $errormessage = '同じユーザーIDが存在します。';
                    return $errormessage;
                }
            }
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(user_id, password) VALUES (:userId, :password)";
            $stmt = $dbconnect->prepare($sql);
            $stmt->bindValue(':userId', $userid);
            $stmt->bindValue(':password', $passwordhash);
            $stmt->execute();
            header('Location:/');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * ログイン処理
     *
     * @param String $userid ユーザーID
     * @return mixed $selectuserinfo DB上のユーザー情報
     */
    public function userLogin($loginuserid)
    {
        try {
            $dbconnect = $this->connectDatabase();
            $sql = "SELECT * FROM users WHERE user_id = :loginuserId";
            $stmt = $dbconnect->prepare($sql);
            $stmt->bindValue(':loginuserId', $loginuserid);
            $stmt->execute();
            $selectuserinfo = $stmt->fetch();
            return $selectuserinfo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * ユーザー管理画面のユーザー情報取得
     * 
     * @return void
     */
    public function getUsersDataWithAscendingOrder()
    {
        try {
            $dbconnect = $this->connectDatabase();
            $sql = "SELECT * FROM users order by seq_no asc;";
            $userstabledata = $dbconnect->prepare($sql);
            $userstabledata->execute();
            $result = $userstabledata->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * データベースからユーザーを削除
     * 
     * @return void
     */
    public function deleteUserDataBySeqNo()
    {
        try {
            $dbconnect = $this->connectDatabase();
            $delete = $_POST['mDeleteButton'];
            $sql = "DELETE FROM users WHERE seq_no = :number;";
            $deleteuserdata = $dbconnect->prepare($sql);
            $deleteuserdata->bindValue(':number', $delete);
            $deleteuserdata->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * 一括削除機能
     * 
     * @return void
     */
    public function deleteBulkUsersDatabase()
    {
        try {
            $dbconnect = $this->connectDatabase();
            $deletemanagechecked = $_POST['deleteManageChecked'];
            $sql = "DELETE FROM users WHERE seq_no = :number;";
            $checkeduserdata = $dbconnect->prepare($sql);
            // foreachで削除するレコードを1件ずつループ処理
            foreach ($deletemanagechecked as $value) {
                // 配列の値を :id にセットし、executeでSQLを実行
                $checkeduserdata->execute(array(':number' => $value));
            }
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }

    /**
     * ユーザー情報の更新
     * 
     * @return void
     */
    public function updateUserDataBySeqNo()
    {
        try {
            $dbconnect = $this->connectDatabase();
            $muserid = $_POST['manageUserId'];
            $sql = "SELECT * FROM users WHERE user_id = :userid;";
            $stmt = $dbconnect->prepare($sql);
            $stmt->bindValue(':userid', $muserid);
            $stmt->execute();
            $users = $stmt->fetchAll();
            foreach ($users as $user) {
                if ($user['user_id']) {
                    $errormessage = '同じユーザーIDが存在します。';
                    return $errormessage;
                }
            }
            $passwordhash = password_hash($_POST['managePassword'], PASSWORD_DEFAULT);
            $update = $_POST['updateButton'];
            $sql = 'UPDATE users set user_id = :userid, password = :password where seq_no = :number;';
            $updateuserdata = $dbconnect->prepare($sql);
            $updateuserdata->bindValue(':userid', $muserid);
            $updateuserdata->bindValue(':password', $passwordhash);
            $updateuserdata->bindValue(':number', $update);
            $updateuserdata->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}