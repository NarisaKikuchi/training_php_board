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

        <div class="login-screen upper">
            <h1>Bulletine Board</h1>
            <p class="login-letter">新規追加画面</p>
        </div>

        <div class="login-screen greybox">
            <div>
                <h2>新規追加</h2>
                <p>ユーザーIDとパスワードを登録してください。</p>
            </div>

            <div>
                <input type="text" value="" placeholder="ユーザーID">
                <div id="password-margin">
                    <input type="text" value="" placeholder="パスワード">
                    <input type="text" value="" placeholder="パスワード確認">
                </div>
            </div>

            <div>
                <div class="login-button">
                    <form type="submit">
                        <button onclick="location.href='login'">登録する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>