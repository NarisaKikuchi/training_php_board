<?php
session_start();

require_once('DatabaseConnect.php');

class UsersTable
{
    /**
     * ユーザー情報新規登録
     * 
     * @param String $user_id, ユーザーID
     * @param String $password, パスワード
     * @return void
     */
    public function insertUserData($user_id, $password)
    {

        try {
            $db_connect = new DatabaseConnect();
            $db_info = $db_connect->connectDatabase();
            $sql = "SELECT * FROM users WHERE user_id = :userId;";
            $stmt = $db_info->prepare($sql);
            $stmt->bindValue(':userId', $user_id);
            $stmt->execute();
            $users = $stmt->fetchAll();
            foreach ($users as $user) {
                if ($user['user_id']) {
                    $error_message = '同じユーザーIDが存在します。';
                    return $error_message;
                }
            }
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(user_id, password) VALUES (:userId, :password)";
            $stmt = $db_info->prepare($sql);
            $stmt->bindValue(':userId', $user_id);
            $stmt->bindValue(':password', $password_hash);
            $stmt->execute();
            header('Location:/');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * ログイン処理
     *
     * @param String $user_id ユーザーID
     * @return mixed $select_user_info DB上のユーザー情報
     */
    public function getUserDataWhereUserId($login_user_id)
    {
        try {
            $db_connect = new DatabaseConnect();
            $db_info = $db_connect->connectDatabase();
            $sql = "SELECT * FROM users WHERE user_id = :loginuserId";
            $stmt = $db_info->prepare($sql);
            $stmt->bindValue(':loginuserId', $login_user_id);
            $stmt->execute();
            $select_user_info = $stmt->fetch();
            return $select_user_info;
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
            $db_connect = new DatabaseConnect();
            $db_info = $db_connect->connectDatabase();
            $sql = "SELECT * FROM users order by seq_no asc;";
            $users_tabledata = $db_info->prepare($sql);
            $users_tabledata->execute();
            $result = $users_tabledata->fetchAll();
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
            $db_connect = new DatabaseConnect();
            $db_info = $db_connect->connectDatabase();
            $delete = $_POST['mDeleteButton'];
            $sql = "DELETE FROM users WHERE seq_no = :number;";
            $delete_user_data = $db_info->prepare($sql);
            $delete_user_data->bindValue(':number', $delete);
            $delete_user_data->execute();
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
            $db_connect = new DatabaseConnect();
            $db_info = $db_connect->connectDatabase();
            $delete_manage_checked = $_POST['deleteManageChecked'];
            $sql = "DELETE FROM users WHERE seq_no = :number;";
            $checked_user_data = $db_info->prepare($sql);
            // foreachで削除するレコードを1件ずつループ処理
            foreach ($delete_manage_checked as $value) {
                // 配列の値を :id にセットし、executeでSQLを実行
                $checked_user_data->execute(array(':number' => $value));
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
            $db_connect = new DatabaseConnect();
            $db_info = $db_connect->connectDatabase();
            $m_user_id = $_POST['manageUserId'];
            $sql = "SELECT * FROM users WHERE user_id = :userid;";
            $stmt = $db_info->prepare($sql);
            $stmt->bindValue(':userid', $m_user_id);
            $stmt->execute();
            $users = $stmt->fetchAll();
            foreach ($users as $user) {
                if ($user['user_id']) {
                    $error_message = '同じユーザーIDが存在します。';
                    return $error_message;
                }
            }
            $password_hash = password_hash($_POST['managePassword'], PASSWORD_DEFAULT);
            $update = $_POST['updateButton'];
            $sql = 'UPDATE users set user_id = :userid, password = :password where seq_no = :number;';
            $update_user_data = $db_info->prepare($sql);
            $update_user_data->bindValue(':userid', $m_user_id);
            $update_user_data->bindValue(':password', $password_hash);
            $update_user_data->bindValue(':number', $update);
            $update_user_data->execute();
        } catch (PDOException $e) {
            echo $e->getMessage;
        }
    }
}