$(function(){

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
