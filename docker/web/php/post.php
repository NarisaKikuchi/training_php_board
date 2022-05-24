<?php
require_once('../../db/postsTable.php');
$table = new postsTable();
$result = $table->display();
?>

<html>

<head>
    <link rel="stylesheet" href="../css/post.css" type="text/css">
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
                        <li class="add-post" id="add-post">投稿追加</li>
                        <li class="mg-user">ユーザー管理</li>
                        <li class="logout">ログアウト</li>
                    </ul>
                </nav>
                <div class="black-bg" id="js-black-bg"></div>
            </div>
        </div>
        <div class="post-modal-wrapper" id="post-modal">
            <div class="modal" id="modal">
                <div class="close-modal">
                    <i class="fa fa-2x fa-times"></i>
                </div>
                <div id="post-form">
                    <h2>投稿追加</h2>
                    <form action="#">
                        <p>投稿タイトル</p>
                        <input id="modal-title" type="text" placeholder="20文字以内で入力してください。">
                        <p>投稿内容</p>
                        <input id="modal-contents" type="text">
                        <div class="post-btn">
                            <input type="submit" value="投稿する">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="heading">
            <h2>投稿一覧
                <div type="submit" class="delete-button">
                    <input onclick="location.href=''" value="削除">
                </div>
            </h2>
        </div>

        <table border="1" cellspacing="0" class="table">
            <tr id="table-header">
                <th class="select">選択</th>
                <th class="no">No.</th>
                <th class="user-id">ユーザーID</th>
                <th class="post-date">投稿日時</th>
                <th class="post-contents">項目(内容)</th>
                <th class="edit">編集</th>
                <th class="delete">削除</th>
            </tr>
            <tbody id="post-data"></tbody>
        </table>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/post.js" type="text/javascript"></script>
</body>

</html>