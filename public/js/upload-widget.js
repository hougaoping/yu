$(function () {
	// 移除现有图片功能
	var uploadWidget = $('.upload-widget');
	uploadWidget.delegate('.remove', 'click', function() {
		var files = uploadWidget.find('.files');
		var id = $(this).attr('data-id');

		var rs = files.val().replace(eval("/" + id + ",?/"), '').replace(/(,*$)/g, "");
		files.val(rs);

		$(this).parent('.image').remove(); // 不能用隐藏，否则删除再上传原来的图片则会无法正常显示

		if (uploadWidget.attr('data-multiple') == 'single') {
			uploadWidget.find('.file-box').show();
		}
		return false;
	});
	
	// 上传功能
	$('.fileupload').fileupload({
		dataType: 'json',
		url: uploadScript,
		progressall: function (e, data) {
			var uploadWidget = $(this).parents('.upload-widget');
			var progress = parseInt(data.loaded / data.total * 100, 10);
			uploadWidget.find('.progress .progress-bar').css('display', 'block');
			uploadWidget.find('.progress .progress-bar').css(
				'width',
				progress + '%'
			);
		},
		add: function (e, data) {
			var uploadWidget = $(this).parents('.upload-widget');
			uploadWidget.find('.progress .progress-bar').css('width', '0px');
			data.submit();
        },
		done: function (e, data) {
			var uploadWidget = $(this).parents('.upload-widget');
			var file  = data.result;
			var files = uploadWidget.find('.files').val();

			var images = uploadWidget.find('.image-list .image span');
			var isInsert = true;
			images.each(function(i) {
				var id = ($(this).attr('data-id'));
				if (id == file['id']) {
					isInsert = false;
				}
			});

			if (isInsert) {
				if (!files) {
					files = file['id'];
				} else {
					files = files + ',' + file['id'];
				}
				uploadWidget.find('.files').val(files);
				uploadWidget.find('.image-list').append('<div class="image"><span class="remove" data-id="' + file['id'] + '">移除</span><img src="'+file['url']+'"></div>');

			}
			uploadWidget.find('.progress .progress-bar').delay(1000).fadeOut();
			
			if (uploadWidget.attr('data-multiple') == 'single') {
				uploadWidget.find('.file-box').hide();
			}
		}
	});
});
