<html>

<head>
    <link rel="stylesheet" href="../css/createAccount.css">
</head>

<body>
    <div class="body">
        <div class="header_left">
            <header class="header_letter">
                Bulletine Board
            </header>
        </div>

        <div class="login_screen upper">
            <h1>Bulletine Board</h1>
            <p class="login_letter">新規追加画面</p>
        </div>

        <div class="login_screen greybox">
            <div>
                <h2>新規追加</h2>
                <p>ユーザーIDとパスワードを登録してください。</p>
            </div>

            <div>
                <input type="text" value="" placeholder="ユーザーID">
                <div id="password_bottom">
                    <input type="text" value="" placeholder="パスワード">
                    <input type="text" value="" placeholder="パスワード確認">
                </div>
            </div>

            <div>
                <div class="login_button">
                    <form type="submit">
                        <button onclick="location.href='login'">登録する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>