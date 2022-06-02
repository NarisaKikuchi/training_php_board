$(function() {

    const postbutton = document.getElementById('post-btn');
    /**
     * 追加投稿時のバリデーションチェック
     * 投稿ボタン押下時の処理
     * 
     * @return void
     */
    function postValidation(posttitle, postcontents) {
        let postalert = [];

        // 入力値チェック
        if (posttitle == "" || postcontents == "") {
            postalert.push("タイトルまたは投稿内容が未入力です。\n");
        }

        // タイトルの文字数制限チェック
        if (posttitle.length > 20) {
            postalert.push("タイトルは20文字以下で入力してください。\n");
        }

        // 投稿内容の文字数制限チェック
        if (postcontents.length > 200) {
            postalert.push("投稿内容は200文字以下で入力してください。\n");
        }

        //　エラーが１つでもヒットしていたらエラー文表示
        if (postalert.length > 0) {
            let postalerts = postalert.join("");
            return postalerts;
        }
    }

    //投稿するボタン押下時
    postbutton.addEventListener('click', function(event) {
        const posttitle = document.getElementById('modal-title').value;
        const postcontents = document.getElementById('modal-contents').value;
        const postalert = postValidation(posttitle, postcontents);
        if (postalert) {
            alert(postalert);
            return;
        }

        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'postsTable',
                    'func': 'addPostDisplay',
                    'postTitle': posttitle,
                    'postContents': postcontents,
                },
            })
            .done(function(data) {
                $('#post-modal').fadeOut();
                getAddPostDatabase();
                $('.black-bg').fadeOut();
                $('.hamburger-menu').toggleClass('open');
                $('.sp-nav').toggleClass('open');
                document.getElementById('modal-title').value = "";
                document.getElementById('modal-contents').value = "";
            }).fail(function(data) {
                alert('通信失敗');
            })
    })

    /**
     * 投稿一覧を表示する
     * 
     * @return void
     */
    function getPostDatabase() {
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'postsTable',
                    'func': 'display',
                },
            })
            .done(function(data) {
                $.each(data, function(key, value) {
                    $('#post-data').append('<tr><td>' + '<input type="checkbox" class="checkbox"></td><td>' +
                        value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td>' +
                        value.post_title + '<br>' + value.post_contents + '</td><td><i class="fa-solid fa-pen-to-square"></i></td><td class="delete-btn" id=' + value.seq_no + '><button>&times;</button></td></tr>'
                    )
                });
            }).fail(function(data) {
                alert('通信失敗');
            })
    }
    getPostDatabase();

    /**
     * 追加された投稿の表示
     * 
     * @return void
     */
    function getAddPostDatabase() {
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'postsTable',
                    'func': 'addDisplay',
                },
            })
            .done(function(data) {
                $.each(data, function(key, value) {
                    $('#post-data').append('<tr><td>' + '<input type="checkbox" class="checkbox"></td><td>' +
                        value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td>' +
                        value.post_title + '<br>' + value.post_contents + '</td><td><i class="fa-solid fa-pen-to-square"></i></td><td class="delete-btn" id=' + value.seq_no + '><button>&times;</button></td></tr>'
                    )
                });
            }).fail(function(data) {
                alert('通信失敗');
            })
    }

    /**
     * 投稿削除
     * 
     * @return void
     */
    //削除アイコン押下時
    $(document).on('click', '.delete-btn', function(value) {
        const number = $(this).attr('id');
        const response = window.confirm('No.' + number + 'の投稿を本当に削除しますか？');
        if (response == false) {
            return;
        }
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'postsTable',
                    'func': 'deletePostDatabese',
                    'deleteButton': number,
                },
            })
            .done(function(data) {
                afterDeletePostDatabase();
                getPostDatabase();
            }).fail(function(data) {
                alert('通信失敗');
            })

        /**
         * 削除後の投稿の表示
         * 
         * @return void
         */
        function afterDeletePostDatabase() {
            $.ajax({
                    type: 'POST',
                    url: '../php/ajax.php',
                    datatype: 'json',
                    data: {
                        'class': 'postsTable',
                        'func': 'display',
                    },
                })
                .done(function(data) {
                    $("#post-data").empty();
                }).fail(function(data) {
                    alert('通信失敗');
                })
        }


        //ハンバーガーメニュー押下時
        const nav = document.getElementById('hamburger-menu');
        const hamburger = document.getElementById('menu-btn');
        const blackBg = document.getElementById('js-black-bg');
        hamburger.addEventListener('click', function() {
            nav.classList.toggle('open');
        });
        blackBg.addEventListener('click', function() {
            nav.classList.remove('open');
        });

        //投稿追加ボタンでモーダル表示
        $('#add-post').click(function() {
            $('#post-modal').fadeIn();
        });

        //バツを押してモーダルを隠す
        $('.close-modal').click(function() {
            $('#post-modal').fadeOut();
        })
    });
});