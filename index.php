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

            <div>
                <input type="text" value="" placeholder="ユーザーID">
                <input type="text" value="" placeholder="パスワード">
            </div>

            <div>
                <div class="login-button">
                    <form type="submit">
                        <button onclick="location.href='login'">ログインする</button>
                    </form>
                </div>
                <div>
                    <a href="docker/web/php/createAccount.php">新規追加はこちら</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>