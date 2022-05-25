$(function(){

    /**
     * 投稿時のバリデーションチェック
     * 
     * @return void
     */
    const postbutton = document.getElementById('post-btn');

    function postValidation() {
        const posttitle = document.getElementById('modal-title');
        const postcontents = document.getElementById('modal-contents');

        postbutton.addEventListener('click', function(event) {
            let postalert = [];

            // 入力値チェック
            if(posttitle.value =="" || postcontents.value==""){
                postalert.push("タイトルまたは投稿内容が未入力です。\n");
            }

            // タイトルの文字数制限チェック
            if(posttitle.value.length > 20){
                postalert.push("タイトルは20文字以下で入力してください。\n");
            }

            // 投稿内容の文字数制限チェック
            if(postcontents.value.length > 200){
                postalert.push("投稿内容は200文字以下で入力してください。\n");
            }

            //　エラーが１つでもヒットしていたらエラー文表示
            if(postalert.length > 0){
                alert(postalert);
            }
        });
    }
    postValidation();

    /**
     * 投稿一覧を表示する
     * 
     * @return void
     */
    function getPostDatabase(){
        $.ajax({
            type:'POST',
            url:'../php/ajax.php',
            datatype:'json',
            data:{
                'class':'postsTable',
                'func':'display',
            },
            })
        .done(function(data){
            $.each(data,function(key,value){
                $('#post-data').append('<tr><td>'+'<input type="checkbox" class="checkbox"></td><td>'
                + value.seq_no + '</td><td>' + value.user_id + '</td><td>' + value.post_date + '</td><td>'
                + value.post_title +'<br>'+value.post_contents+'</td><td><i class="fa-solid fa-pen-to-square"></i></td><td>&times;</td></tr>'
        )});
        }).fail(function (data){
            alert('通信失敗');
        })
    }
    getPostDatabase();


    var nav = document.getElementById('hamburger-menu');
    var hamburger = document.getElementById('menu-btn');
    var blackBg = document.getElementById('js-black-bg');

    hamburger.addEventListener('click', function () {
        nav.classList.toggle('open');
    });
    blackBg.addEventListener('click', function () {
        nav.classList.remove('open');
    });

    $('#add-post').click(function() {
        $('#post-modal').fadeIn();
    });

    $('.close-modal').click(function() {
        $('#post-modal').fadeOut();
    })

});

