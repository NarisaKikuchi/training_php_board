<?php
require_once('../../db/postsTable.php');
$table = new postsTable();
$result = $table->display();
?>

<html>

<head>
    <link rel="stylesheet" href="../css/post.css">
    <script src="https://kit.fontawesome.com/e330008995.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <header class="header-letter">
                Bulletine Board
            </header>
            <p>MENU</p>
            <div class="hamburger-menu">
                <input type="checkbox" id="menu-btn-check">
                <label for="menu-btn-check" class="menu-btn"><span></span></label>
                <nav>
                    <ul class="inner">
                        <li><a href="#">投稿追加</a></li>
                        <li><a href="#">ユーザー管理</a></li>
                        <li><a href="#">ログアウト</a></li>
                    </ul>
                </nav>
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
            <tbody id="table-cells">
                <!-- Foreachの処理 -->
                <?php foreach ($result as $value) : ?>
                <tr>
                    <td><input type="checkbox" class="checkbox"></td>
                    <td><?php echo $value['seq_no'] ?></td>
                    <td><?php echo $value['user_id'] ?></td>
                    <td><?php echo $value['post_date'] ?></td>
                    <td><?php echo $value['post_title'] . "\n" . $value['post_contents'] ?></td>
                    <td type="submit"><i class="fa-solid fa-pen-to-square"></td>
                    <td type="submit">&times;</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    </div>
</body>

</html>