function ajaxPost(form, callbackSuccess, callbackError) {
    return $.ajax({
        url: form.attr('action'),
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: form.serialize(),
        success: function(return_data) {
            callbackSuccess ? callbackSuccess(return_data) : (function(return_data) {
                if (return_data.data.direct == false || return_data.url == '') {
                    return_data.url = undefined;
                }
                
                $.message({
                    type: 'success',
                    html: return_data.message,
                    showHtml: function(el, time) {
                                    // el.html(return_data.message + ' ' + time);
                                    el.html(return_data.message);
                                },
                    url: return_data.url,
                    timeout: return_data.wait * 1000
                });
            })(return_data);
        },
        error: function(return_data) {
            var json = JSON.parse(return_data.responseText);
            callbackError ? callbackError(json) : (function(return_data) {
                // 显示laravel返回的错误列表中的第一条
                if (return_data.errors) {
                    $.each(return_data.errors, function(idx, obj) {
                        $.message({
                            type: 'error',
                            html: obj[0],
                        });
                        return false;
                    });
                }else {
                    $.message({
                        type: 'error',
                        html: return_data.message
                    });  
                }
            })(json);
        }
    });
}

// $('#form').ajaxPost(function(){}, function(){}).then(function(){}, function(){})
$.fn.ajaxPost = function (callbackSuccess, callbackError){
    return ajaxPost.apply(null, [this, callbackSuccess, callbackError]); // this === form
};