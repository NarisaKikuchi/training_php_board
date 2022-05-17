<?php
require_once('createAccountController.php');
require_once('../../db/usersTable.php');

//登録するボタンが押された場合
//issetが引数に指定した変数に値が設定されている
if (isset($_POST["signUp"])) {
    $userId = htmlspecialchars($_POST["userId"], ENT_QUOTES);
    $password = $_POST['password'];
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $passwordConfirm = $_POST['passwordConfirm'];
    $passwordConfirmHash = password_hash($_POST['passwordConfirm'], PASSWORD_DEFAULT);
    $validationCheck = new validationUtil();
    $errorMessage = $validationCheck->validation($userId, $password, $passwordConfirm);
    if (!empty($errorMessage)) {
        $alerts = "<script type='text/javascript'>alert('$errorMessage');</script>";
        echo $alerts;
    } else {
        $registration = new usersTable();
        $registration->regist($userId, $passwordHash);
    }
} ?>

<html>

<head>
    <link rel="stylesheet" href="../css/createAccount.css">
</head>

<body>
    <div class="body">
        <div class="header-left">
            <header class="header-letter">
                Bulletine Board
            </header>
        </div>
        <form type="submit" class="return-button">
            <input onclick="location.href='../../../index.php'" value="戻る">
        </form>
        <div class="login-screen upper">
            <h1>Bulletine Board</h1>
            <p class="login-letter">新規追加画面</p>
        </div>
        <div class="login-screen greybox">
            <div>
                <h2>新規追加</h2>
                <p>ユーザーIDとパスワードを登録してください。</p>
            </div>

            <form action="" method="post">
                <div>
                    <input type="text" name="userId" maxlength="20" value="" autocomplete="off" placeholder="ユーザーID">
                    <div class="password-margin">
                        <input type="password" name="password" maxlength="30" autocomplete="off" placeholder="パスワード">
                    </div>
                    <input type="password" name="passwordConfirm" maxlength="30" autocomplete="off"
                        placeholder="パスワード確認">
                </div>
                <div class="regist-button">
                    <input type="submit" name="signUp" value="登録する">
                </div>
            </form>
        </div>
    </div>
</body>

</html>