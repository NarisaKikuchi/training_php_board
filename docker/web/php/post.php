<html>

<head>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="body">
        <div class="header_left">
            <header class="header_letter">
                Bulletine Board
            </header>
        </div>
        <div>
            <h1>投稿一覧</h1>
        </div>
        <table border="1">
            <tr>
                <th>選択</th>
                <th>No</th>
                <th>投稿日時</th>
                <th>ユーザーID</th>
                <th>項目(内容)</th>
                <th>編集</th>
                <th>削除</th>
            </tr>

            <tr>
                <td>"post_date"</td>
                <td>"user_id"</td>
                <td>"post_title"</td>
                <td>"post_contents"</td>
            </tr>
        </table>

        <div class="login_screen greybox">
            <div>
                <h2>ログイン</h2>
                <p>ユーザーIDとパスワードを入力してください。</p>
            </div>

            <div>
                <input type="text" value="" placeholder="ユーザーID">
                <input type="text" value="" placeholder="パスワード">
            </div>

            <div>
                <div class="login_button">
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