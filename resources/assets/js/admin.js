require('./bootstrap');

$(function() {
    $(".menus .menu-headline").click(function(){
        $(this).toggleClass("current");
        $(this).next(".menu-body").slideToggle(200).parent().siblings().find('.menu-body').slideUp("slow");
        $(this).parent().siblings().find('.menu-headline').removeClass("current");
    });

    // 下拉菜单
    // if ($('.drop-menu').length && $('.drop-menu').length > 0) {
    //     $('.drop-menu').hover(function() {
    //         $(this).addClass('active');
    //     },
    //     function() {
    //         $(this).removeClass('active');
    //     });
    // }

    $('.submit').click(function() {
        if ($(this).hasClass('delete') && confirm('确定删除选中项吗？')) {
            $(this).parent('form').submit();
        }
        return false;
    });
});
