function open(element, fun, url, title, area) {
    $(element).click(function(){
        href = url;
        if (url == undefined) {
            var href = $(this).attr('href');
            if (href == undefined) {
                href = $(this).attr('data-url');
            }
        }
        if (title == undefined) {
            var title = $(this).attr('title');
        }
        if (area == undefined) {
            var area = $(this).attr('data-area').split(',');
        }
        openLayer(href, title, area, 0.6, true, fun);
        return false;
    });
}

// 对layer进行简单封装
function openLayer(url, title, area, shade, close, fun) {
    if (shade == undefined) {
        shade = 0.6
    }

    if (close == undefined) {
        close = true;
    }

    layer.open({
        type: 2,
        title: title,
        shadeClose: close,
        shade: shade,
        area: area,
        shift: 2,
        content: url, //iframe的url
        skin: 'layui-layer-rim', //加上边框
        end: fun,
    });
}