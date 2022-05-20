<?php

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
}