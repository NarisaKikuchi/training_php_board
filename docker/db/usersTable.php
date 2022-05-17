<?php
// require_once('../web/createAccount.php');
// require_once('../web/createAccountController.php');

class usersTable
{
    public function db()
    {
        $dsn = 'pgsql:dbname=board_database; host=db; port=5555;';
        $dbpassword = 'password';
        $username = 'root';
        $dbh = new PDO($dsn, $username, $dbpassword);
        return $dbh;
    }


    public function regist($userId, $password)
    {

        try {
            $dbo = $this->db();
            $sql = "SELECT * FROM users WHERE user_id = :userId;";
            $stmt = $dbo->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $users = $stmt->fetchAll();
            foreach ($users as $user) {
                if ($user['user_id']) {
                    $errorMessage = '同じユーザーIDが存在します。';
                    return $errorMessage;
                }
            }
            $sql = "INSERT INTO users(user_id, password) VALUES (:userId, :password)";
            $stmt = $dbo->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->bindValue(':password', $password);
            $stmt->execute();
            header('Location: ../../index.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login($userId, $password)
    {
        try {
            $dbo = $this->db();
            $sql = "SELECT * FROM users WHERE seq_no = :seqNo";
            $stmt = $dbo->prepare($sql);
            $stmt->bindValue(':seqNo', $seqNo);
            $stmt->execute();
            header('Location: ');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}