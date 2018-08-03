require('./bootstrap');

$(function() {
    // 下拉菜单
    if ($('.drop-menu').length && $('.drop-menu').length > 0) {
        $('.drop-menu').hover(function() {
            $(this).addClass('active');
        },
        function() {
            $(this).removeClass('active');
        });
    }

    // 美化radios选项
    $(".input_radio").click(function() {
        $(".input_radio").removeClass("selected");
        $(".input_radio input").attr("selected", false);

        var _this = $(this);
        _this.addClass("selected");
        _this.find('input').attr("checked", true);
    });

    // 回到页面顶部
    $('.goto-top').click(function (){
        $('html,body').stop().animate({
            scrollTop: 0
        });
    });
    $(window).scroll(function (){
        if (Math.max($('body').scrollTop(), $('html').scrollTop()) > 50) {
            $('.goto-top').fadeIn(300);
        }else{
            $('.goto-top').fadeOut(300);
        }
    });

    setFooter();
    $(window).resize(setFooter)
});

function setFooter() {
    var hasScroller = document.documentElement.clientHeight < document.documentElement.scrollHeight;
    if (!hasScroller) {
        $(".footer").removeClass('footer_2');
        $(".footer").addClass('footer_1');
    }else{
        $(".footer").removeClass('footer_1');
        $(".footer").addClass('footer_2');
    }
}
