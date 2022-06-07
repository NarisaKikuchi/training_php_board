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

    //バツを押して投稿モーダルを隠す
    $('.close-modal').click(function() {
        $('#post-modal').fadeOut();
    });

    //バツを押して編集モーダルを隠す
    $('.manage-close-modal').click(function() {
        $('#manage-users-modal').fadeOut();
    });

    //編集アイコン押下時の処理
    $(document).on('click', '.m-edit-btn', function() {
        //編集時のユーザーID
        const manageusernumber = $(this).attr('id');
        const manageuserid = document.getElementById('manage-userid-' + manageusernumber).innerHTML;
        document.getElementById('m-user-id').value = manageuserid;
        //seq_noの紐付け
        document.getElementById('m-edit-seq').value = manageusernumber;
        $('#manage-users-modal').fadeIn();
    });

    const updatebutton = document.getElementById('update-user-btn');
    /**
     * 追加投稿時のバリデーションチェック
     * 投稿ボタン押下時の処理
     * 
     * @return String | void
     */
    function manageUserValidation(manageuserid, managepassword, managepasswordconfirm) {
        let managealert = [];

        // 入力値チェック
        if (manageuserid === "" || managepassword === "" || managepasswordconfirm === "") {
            managealert.push("未入力の項目があります。\n");
        }

        // ユーザーIDの半角英数・文字数制限チェック
        if (manageuserid.length > 20 || manageuserid.match("/^[0-9a-zA-Z]*$/")) {
            managealert.push("ユーザーIDは半角英数入力20文字以下でしてください。\n");
        }

        // パスワードの半角英数・文字数制限チェック
        if (managepassword.length > 30 || managepassword.match("/^[0-9a-zA-Z]*$/")) {
            managealert.push("パスワードは半角英数入力30文字以下でしてください。\n");
        }

        // 確認用パスワードの半角英数・文字数制限チェック
        if (managepasswordconfirm.length > 30 || managepasswordconfirm.match("/^[0-9a-zA-Z]*$/")) {
            managealert.push("パスワード確認は半角英数入力30文字以下でしてください。\n");
        }

        //パスワード確認チェック
        if (managepassword !== managepasswordconfirm) {
            managealert.push("パスワードが一致していません。");
        }

        //　エラーが１つでもヒットしていたらエラー文表示
        if (managealert.length > 0) {
            let managealerts = managealert.join("");
            return managealerts;
        }
    }

    //編集時の変更するボタン押下時
    updatebutton.addEventListener('click', function(event) {
        const muserid = document.getElementById('m-user-id').value;
        const mpassword = document.getElementById('m-password').value;
        const mpasswordconfirm = document.getElementById('m-password-confirm').value;
        const seqno = document.getElementById('m-edit-seq').value;
        const postalert = manageUserValidation(muserid, mpassword, mpasswordconfirm);
        if (postalert) {
            alert(postalert);
            return;
        }
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'usersTable',
                    'func': 'updateUserDataBySeqNo',
                    'manageUserId': muserid,
                    'managePassword': mpassword,
                    'updateButton': seqno,
                },
            })
            .done(function(data) {
                $('#manage-users-modal').fadeOut();
                $("#user-data").empty();
                getUsersDatabase();
                $('.black-bg').fadeOut();
                document.getElementById('m-user-id').value = "";
                document.getElementById('m-password').value = "";
                document.getElementById('m-password-confirm').value = "";
            }).fail(function(data) {
                alert('通信失敗');
            })
    })

    /**
     * ユーザー一覧を表示する
     *
     * @return void
     */
    function getUsersDatabase() {
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'usersTable',
                    'func': 'getUsersDataWithAscendingOrder',
                },
            })
            .done(function(data) {
                $.each(data, function(key, value) {
                    $('#user-data').append('<tr><td>' +
                        '<input type="checkbox" class="check" id="checkbox" value=' + value.seq_no + '></td><td>' +
                        value.seq_no + '</td><td id="manage-userid-' + value.seq_no + '">' + value.user_id + '</td><td class="m-edit-btn" id=' + value.seq_no +
                        '><i class="fa-solid fa-pen-to-square"></i></td><td class="m-delete-btn" id=' + value.seq_no +
                        '>&times;</td></tr>'
                    )
                });
            }).fail(function(data) {
                alert('通信失敗');
            })
    }
    getUsersDatabase();

    /**
     * ユーザー削除
     * 
     * @return void
     */
    //削除アイコン押下時
    $(document).on('click', '.m-delete-btn', function(value) {
        const usernumber = $(this).attr('id');
        const response = window.confirm('No.' + usernumber + 'のユーザーを本当に削除しますか？');
        if (response == false) {
            return;
        }
        $.ajax({
                type: 'POST',
                url: '../php/ajax.php',
                datatype: 'json',
                data: {
                    'class': 'usersTable',
                    'func': 'deleteUserDataBySeqNo',
                    'mDeleteButton': usernumber,
                },
            })
            .done(function(data) {
                $("#user-data").empty();
                getUsersDatabase();
            }).fail(function(data) {
                alert('通信失敗');
            })
    })

    //選択削除機能
    function bulkManageDelete() {
        $("#m-dlt-btn").prop("disabled", true);
        $(document).on('change', '#checkbox', function() {
            // チェックされているチェックボックスの数
            if ($("#checkbox:checked").length > 0) {
                // ボタン有効
                $("#m-dlt-btn").prop("disabled", false);
            } else {
                // ボタン無効
                $("#m-dlt-btn").prop("disabled", true);
            }
        });

        //削除ボタン押下時
        $(document).on('click', '#m-dlt-btn', function(value) {
            const arr = [];
            const check = document.getElementsByClassName("check");

            for (let i = 0; i < check.length; i++) {
                if (check[i].checked) {
                    arr.push(check[i].value);
                }
            }
            const checkmanageres = window.confirm('No.' + arr + 'のユーザーを本当に削除しますか？');
            if (checkmanageres == false) {
                return;
            }

            $.ajax({
                    type: 'POST',
                    url: '../php/ajax.php',
                    datatype: 'json',
                    data: {
                        'class': 'usersTable',
                        'func': 'deleteBulkUsersDatabase',
                        'deleteManageChecked': checkedmanagenumber,
                    },
                })
                .done(function(data) {
                    $("#user-data").empty();
                    getUsersDatabase();
                }).fail(function(data) {
                    alert('通信失敗');
                })
        })
    }
    bulkManageDelete();
});