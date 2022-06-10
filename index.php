<?php
require_once('docker/web/php/Validation.php');
require_once('docker/db/UsersTable.php');

if (isset($_POST["login"])) {
    $login_user_id = htmlspecialchars($_POST["loginUserId"], ENT_QUOTES);
    $login_password = $_POST['loginPassword'];
    $login_validation_check = new Validation();
    $login_error_message = $login_validation_check->userLoginValidation($login_user_id, $login_password);
    if (!empty($login_error_message)) {
        $error = "<script type='text/javascript'>alert('$login_error_message');</script>";
        echo $error;
    } else {
        header('Location: docker/web/php/post.php');
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="../docker/web/css/index.css">
</head>

<body>
    <div class="body">
        <div class="header-left">
            <header class="header-letter">
                Bulletine Board
            </header>
        </div>

        <div class="login-screen upper">
            <h1>Bulletine Board</h1>
            <p class="login-letter">ログイン画面</p>
        </div>

        <div class="login-screen greybox">
            <div>
                <h2>ログイン</h2>
                <p>ユーザーIDとパスワードを入力してください。</p>
            </div>
            <form action="" method="post">
                <div>
                    <input type="text" name="loginUserId" maxlength="20" pattern="^[a-zA-Z0-9]+$" value=""
                        placeholder="ユーザーID">
                    <input type="password" name="loginPassword" maxlength="30" pattern="^[a-zA-Z0-9]+$" value=""
                        placeholder="パスワード">
                </div>

                <div>
                    <div class="login-button">
                        <input type="submit" name="login" value="ログインする">
                    </div>
                </div>
                <div>
                    <a href="docker/web/php/createaccount.php">新規追加はこちら</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>