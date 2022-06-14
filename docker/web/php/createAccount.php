<?php
require_once('Validation.php');
require_once('../../db/UsersTable.php');

//登録するボタンが押された場合
//issetが引数に指定した変数に値が設定されている
if (isset($_POST["signUp"])) {
    $user_id = htmlspecialchars($_POST["userId"], ENT_QUOTES);
    $password = $_POST['password'];
    $password_confirm = $_POST['passwordConfirm'];
    $validation_check = new Validation();
    $error_message = $validation_check->userRegistValidation($user_id, $password, $password_confirm);
    if (!empty($error_message)) {
        $alerts = "<script type='text/javascript'>alert('$error_message');</script>";
        echo $alerts;
    } else {
        $registration = new UsersTable();
        $registration->insertUserData($user_id, $password);
    }
} ?>

<html>

<head>
    <link rel="stylesheet" href="../css/createaccount.css">
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