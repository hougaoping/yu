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
    
    // 美化注册页面radios选项
    $(".input_radio").click(function() {
        $(".input_radio").removeClass("selected");
        $(".input_radio input").attr("selected", false);

        var _this = $(this);
        _this.addClass("selected");
        _this.find('input').attr("selected", true);
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