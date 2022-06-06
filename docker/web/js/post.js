$(function() {

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
        const nember = event.attr();
        const posttitle = document.getElementById('edit-title-' + value.post_title).innerHTML;
        const titlesplit = posttitle.split("<br>");
        document.getElementById('edit-modal-title').value = titlesplit[0]
        alert(titlesplit[0]);
        //編集時のモーダルコンテンツ
        const postcontents = document.getElementById('edit-modal-contents').innerHTML;
        const contentssplit = postcontents.split("<br>");
        document.getElementById('edit-modal-title').value = contentssplit[1]
        alert(contentssplit[1]);
    });

    //バツを押して編集モーダルを隠す
    $('.edit-close-modal').click(function() {
        $('#edit-post-modal').fadeOut();
    });


    const postbutton = document.getElementById('post-btn');
    /**
     * 追加投稿時のバリデーションチェック
     * 投稿ボタン押下時の処理
     * 
     * @return String | void
     */
    function postValidation(posttitle, postcontents) {
        let postalert = [];

        // 入力値チェック
        if (posttitle === "" || postcontents === "") {
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
                    'func': 'insertPostData',
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

    //編集アイコン押下時の処理
    $(document).on('click', '.edit-btn', function() {
        //編集時のモーダルタイトル
        const editnumber = $(this).attr('id');
        const posttitle = document.getElementById('edit-title-' + editnumber).innerHTML;
        const titlesplit = posttitle.split("<br>");
        document.getElementById('edit-modal-title').value = titlesplit[0];
        //編集時のモーダルコンテンツ
        document.getElementById('edit-modal-contents').value = titlesplit[1];
        //seq_noの紐付け
        document.getElementById('edit-seq').value = editnumber;
        $('#edit-post-modal').fadeIn();
    });

    //編集時の投稿するボタン押下時
    const editpostbutton = document.getElementById('edit-post-btn');
    editpostbutton.addEventListener('click', function(event) {
        const posttitle = document.getElementById('edit-modal-title').value;
        const postcontents = document.getElementById('edit-modal-contents').value;
        const seqno = document.getElementById('edit-seq').value
        const editpostalert = postValidation(posttitle, postcontents);
        if (editpostalert) {
            alert(editpostalert);
            return;
        }

        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'postsTable',
                    'func': 'updatePostDataBySeqNo',
                    'postTitle': posttitle,
                    'postContents': postcontents,
                    'editButton': seqno,
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
                    'class': 'postsTable',
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
                    'func': 'getPostWhereMaxSeqNo',
                },
            })
            .done(function(data) {
                $.each(data, function(key, value) {
                    $('#post-data').append('<tr><td>' + '<input type="checkbox" class="checkbox"></td><td>' +
                        value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td>' +
                        value.post_title + '<br>' + value.post_contents + '</td><td><i class="fa-solid fa-pen-to-square" id="edit-btn"></i></td><td class="delete-btn" id=' + value.seq_no + '><button>&times;</button></td></tr>'
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
                    'func': 'deletePostDataBySeqNo',
                    'deleteButton': number,
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
    }

    //削除ボタン押下時
    $(document).on('click', '#dlt-btn', function(value) {
        const arr = [];
        const check = document.getElementsByClassName("check");

        for (let i = 0; i < check.length; i++) {
            if (check[i].checked) {
                arr.push(check[i].value);
            }
        }
        const checkednumber = arr;
        const checkres = window.confirm('No.' + checkednumber + 'の投稿を本当に削除しますか？');
        if (checkres == false) {
            return;
        }

        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'postsTable',
                    'func': 'deleteBulkPostDatabase',
                    'deleteChecked': checkednumber,
                },
            })
            .done(function(data) {
                $("#post-data").empty();
                getPostDatabase();
            }).fail(function(data) {
                alert('通信失敗');
            })
    })
});