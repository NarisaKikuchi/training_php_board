$(function() {

    //ハンバーガーメニュー押下時
    const NAV = document.getElementById('hamburger-menu');
    const HAMBURGER = document.getElementById('menu-btn');
    const BLACK_BG = document.getElementById('js-black-bg');
    HAMBURGER.addEventListener('click', function() {
        NAV.classList.toggle('open');
    });
    BLACK_BG.addEventListener('click', function() {
        NAV.classList.remove('open');
    });

    //投稿追加ボタンを押下時にモーダル表示
    $('#add-post').click(function() {
        $('#post-modal').fadeIn();
    })

    //バツを押して投稿モーダルを隠す
    $('.close-modal').click(function() {
        $('#post-modal').fadeOut();
    });

    //編集アイコン押下でモーダル表示
    $(document).on('click', '#edit-btn', function(event) {
        $('#edit-post-modal').fadeIn();
        //編集時のモーダルタイトル
        const POST_TITLE = document.getElementById('edit-title-' + value.post_title).innerHTML;
        const TITLE_SPLIT = POST_TITLE.split("<br>");
        document.getElementById('edit-modal-title').value = TITLE_SPLIT[0]
        alert(TITLE_SPLIT[0]);
        //編集時のモーダルコンテンツ
        const POST_CONTENTS = document.getElementById('edit-modal-contents').innerHTML;
        const CONTENTS_SPLIT = POST_CONTENTS.split("<br>");
        document.getElementById('edit-modal-title').value = CONTENTS_SPLIT[1]
        alert(CONTENTS_SPLIT[1]);
    });

    //バツを押して編集モーダルを隠す
    $('.edit-close-modal').click(function() {
        $('#edit-post-modal').fadeOut();
    });


    const POST_BUTTON = document.getElementById('post-btn');
    /**
     * 追加投稿時のバリデーションチェック
     * 投稿ボタン押下時の処理
     * 
     * @return String | void
     */
    function postValidation(POST_TITLE, POST_CONTENTS) {
        let post_alert = [];

        // 入力値チェック
        if (POST_TITLE === "" || POST_CONTENTS === "") {
            post_alert.push("タイトルまたは投稿内容が未入力です。\n");
        }

        // タイトルの文字数制限チェック
        if (POST_TITLE.length > 20) {
            post_alert.push("タイトルは20文字以下で入力してください。\n");
        }

        // 投稿内容の文字数制限チェック
        if (POST_CONTENTS.length > 200) {
            post_alert.push("投稿内容は200文字以下で入力してください。\n");
        }

        //　エラーが１つでもヒットしていたらエラー文表示
        if (post_alert.length > 0) {
            let post_alerts = post_alert.join("");
            return post_alerts;
        }
    }

    //投稿するボタン押下時
    POST_BUTTON.addEventListener('click', function(event) {
        const POST_TITLE = document.getElementById('modal-title').value;
        const POST_CONTENTS = document.getElementById('modal-contents').value;
        const POST_ALERT = postValidation(POST_TITLE, POST_CONTENTS);
        if (POST_ALERT) {
            alert(POST_ALERT);
            return;
        }

        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'PostsTable',
                    'func': 'insertPostData',
                    'postTitle': POST_TITLE,
                    'postContents': POST_CONTENTS,
                },
            })
            .done(function(data) {
                $('#post-modal').fadeOut();
                $("#post-data").empty();
                getPostDatabase();
                $('.black-bg').fadeOut();
                $('.hamburger-menu').toggleClass('open');
                $('.sp-nav').toggleClass('open');
                document.getElementById('modal-title').value = "";
                document.getElementById('modal-contents').value = "";
            }).fail(function(data) {
                alert('通信失敗');
            })
    })

    //編集アイコン押下時の処理
    $(document).on('click', '.edit-btn', function() {
        //編集時のモーダルタイトル
        const EDIT_NUMBER = $(this).attr('id');
        const POST_TITLE = document.getElementById('edit-title-' + EDIT_NUMBER).innerHTML;
        const TITLE_SPLIT = POST_TITLE.split("<br>");
        document.getElementById('edit-modal-title').value = TITLE_SPLIT[0];
        //編集時のモーダルコンテンツ
        document.getElementById('edit-modal-contents').value = TITLE_SPLIT[1];
        //seq_noの紐付け
        document.getElementById('edit-seq').value = EDIT_NUMBER;
        $('#edit-post-modal').fadeIn();
    });

    //編集時の投稿するボタン押下時
    const EDIT_POST_BUTTON = document.getElementById('edit-post-btn');
    EDIT_POST_BUTTON.addEventListener('click', function(event) {
        const POST_TITLE = document.getElementById('edit-modal-title').value;
        const POST_CONTENTS = document.getElementById('edit-modal-contents').value;
        const SEQ_NO = document.getElementById('edit-seq').value
        const EDIT_POST_ALERT = postValidation(POST_TITLE, POST_CONTENTS);
        if (EDIT_POST_ALERT) {
            alert(EDIT_POST_ALERT);
            return;
        }

        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'PostsTable',
                    'func': 'updatePostDataBySeqNo',
                    'postTitle': POST_TITLE,
                    'postContents': POST_CONTENTS,
                    'editButton': SEQ_NO,
                },
            })
            .done(function(data) {
                $('#edit-post-modal').fadeOut();
                $("#post-data").empty();
                getPostDatabase();
                $('.black-bg').fadeOut();
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
                    'class': 'PostsTable',
                    'func': 'getPostDataWithAscendingOrder',
                },
            })
            .done(function(data) {
                $.each(data, function(key, value) {
                    $('#post-data').append('<tr><td>' + '<input type="checkbox" class="check" id="checkbox" value=' + value.seq_no + '></td><td>' +
                        value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td id="edit-title-' + value.seq_no + '">' +
                        value.post_title + '<br>' + value.post_contents + '</td><td class="edit-btn" id=' + value.seq_no + '><i class="fa-solid fa-pen-to-square"></i></td><td class="delete-btn" id=' + value.seq_no + '>&times;</td></tr>'
                    )
                });
            }).fail(function(data) {
                alert('通信失敗');
            })
    }
    getPostDatabase();

    /**
     * 投稿削除
     * 
     * @return void
     */
    //削除アイコン押下時
    $(document).on('click', '.delete-btn', function(value) {
        const NUMBER = $(this).attr('id');
        const RESPONSE = window.confirm('No.' + NUMBER + 'の投稿を本当に削除しますか？');
        if (RESPONSE == false) {
            return;
        }
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'PostsTable',
                    'func': 'deletePostDataBySeqNo',
                    'deleteButton': NUMBER,
                },
            })
            .done(function(data) {
                $("#post-data").empty();
                getPostDatabase();
            }).fail(function(data) {
                alert('通信失敗');
            })
    })

    //選択削除機能
    function bulkDelete() {
        $("#dlt-btn").prop("disabled", true);
        $(document).on('change', '#checkbox', function() {
            // チェックされているチェックボックスの数
            if ($("#checkbox:checked").length > 0) {
                // ボタン有効
                $("#dlt-btn").prop("disabled", false);
            } else {
                // ボタン無効
                $("#dlt-btn").prop("disabled", true);
            }
        });


        //削除ボタン押下時
        $(document).on('click', '#dlt-btn', function(value) {
            const ARR = [];
            const CHECK = document.getElementsByClassName("check");

            for (let i = 0; i < CHECK.length; i++) {
                if (CHECK[i].checked) {
                    ARR.push(CHECK[i].value);
                }
            }
            const CHECK_RES = window.confirm('No.' + ARR + 'の投稿を本当に削除しますか？');
            if (CHECK_RES == false) {
                return;
            }

            $.ajax({
                    type: 'POST',
                    url: '../php/ajax.php',
                    datatype: 'json',
                    data: {
                        'class': 'PostsTable',
                        'func': 'deleteBulkPostData',
                        'deleteChecked': CHECKED_NUMBER,
                    },
                })
                .done(function(data) {
                    $("#post-data").empty();
                    getPostDatabase();
                }).fail(function(data) {
                    alert('通信失敗');
                })
        });
    }
    bulkDelete();

    //ソートボタンの処理
    //昇順機能
    const ASC_BUTTON = document.getElementById('asc-btn');

    function sortByAscending() {
        ASC_BUTTON.addEventListener('click', function(event) {
            $.ajax({
                    type: 'POST',
                    url: '../php/ajax.php',
                    datatype: 'json',
                    data: {
                        'class': 'PostsTable',
                        'func': 'getPostDataWithAscendingOrderByDate',
                    },
                })
                .done(function(data) {
                    $("#post-data").empty();
                    $.each(data, function(key, value) {
                        $('#post-data').append('<tr><td>' + '<input type="checkbox" class="check" id="checkbox" value=' + value.seq_no + '></td><td>' +
                            value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td id="edit-title-' + value.seq_no + '">' +
                            value.post_title + '<br>' + value.post_contents + '</td><td class="edit-btn" id=' + value.seq_no + '><i class="fa-solid fa-pen-to-square"></i></td><td class="delete-btn" id=' + value.seq_no + '>&times;</td></tr>'
                        )
                    });
                }).fail(function(data) {
                    alert('通信失敗');
                })
        });
    }
    sortByAscending();

    //降順機能
    const DESC_BUTTON = document.getElementById('desc-btn');

    function sortByDescending() {
        DESC_BUTTON.addEventListener('click', function(event) {
            $.ajax({
                    type: 'POST',
                    url: '../php/ajax.php',
                    datatype: 'json',
                    data: {
                        'class': 'PostsTable',
                        'func': 'getPostDataWithDescendingOrderByDate',
                    },
                })
                .done(function(data) {
                    $("#post-data").empty();
                    $.each(data, function(key, value) {
                        $('#post-data').append('<tr><td>' + '<input type="checkbox" class="check" id="checkbox" value=' + value.seq_no + '></td><td>' +
                            value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td id="edit-title-' + value.seq_no + '">' +
                            value.post_title + '<br>' + value.post_contents + '</td><td class="edit-btn" id=' + value.seq_no + '><i class="fa-solid fa-pen-to-square"></i></td><td class="delete-btn" id=' + value.seq_no + '>&times;</td></tr>'
                        )
                    });
                }).fail(function(data) {
                    alert('通信失敗');
                })
        });
    }
    sortByDescending();

});