<?php
session_start();

//別のウィンドウで開いたとき、ログインページに飛ばす
if (!isset($_SESSION["loginUserId"])) {
    header('Location: ../../../index.php');
}
?>


<html>

<head>
    <link rel="stylesheet" href="../css/manageusers.css" type="text/css">
    <script src="https://kit.fontawesome.com/e330008995.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <header class="header-letter">
                Bulletine Board
            </header>
            <p>MENU</p>
            <div class="hamburger-menu" id="hamburger-menu">
                <button type="button" class="menu-btn-check" id="menu-btn-check">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <label for="menu-btn-check" class="menu-btn" id="menu-btn"><span></span></label>
                <nav class="sp-nav">
                    <ul class="inner">
                        <li class="add-post" id="add-post"><a href="post.php">投稿一覧</a></li>
                        <li class="logout" name="logout"><a href="../../db/logout.php">ログアウト</a></li>
                    </ul>
                </nav>
                <div class="black-bg" id="js-black-bg"></div>
            </div>
        </div>

        <!-- 編集モーダル -->
        <div class="manage-users-modal-wrapper" id="manage-users-modal">
            <div class="manage-users-modal" id="manage-users-modal">
                <div class="manage-close-modal">
                    <i class="fa fa-2x fa-times"></i>
                </div>
                <div id="users-form">
                    <h2>ユーザー情報編集</h2>
                    <p>ユーザーID</p>
                    <input id="m-user-id" name="mUserId" type="text" maxlength="20">
                    <input id="m-edit-seq" type="hidden">
                    <p>パスワード</p>
                    <input id="m-password" name="mPassword" type="password" maxlength="30">
                    <input id="m-password-confirm" name="mPasswordConfirm" type="password" maxlength="30">
                    <div class="update-user-btn">
                        <input class="update-user-btn" id="update-user-btn" name="updateUserButton" type="submit"
                            value="変更する">
                    </div>
                </div>
            </div>
        </div>

        <div class="heading">
            <h2>ユーザー管理</h2>
        </div>
        <div class="title">
            <p>ユーザー一覧
            <div type="submit" class="m-dlt-button">
                <input id="m-dlt-btn" onclick="location.href=''" value="削除">
            </div>
            </p>
        </div>

        <table border="1" cellspacing="0" class="table">
            <tr id="table-header">
                <th class="select">選択</th>
                <th class="no">No.</th>
                <th class="user-id">ユーザーID</th>
                <th class="edit">編集</th>
                <th class="delete">削除</th>
            </tr>
            <tbody id="user-data"></tbody>
        </table>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/manageusers.js" type="text/javascript"></script>
</body>

</html>