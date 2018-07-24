jQuery.fn.idTabs = function (id){
	var ret = this.data('idTabs');
	if(!ret){
		var css = 'selected';
		// console.log(this)
		var items = this.find('a');
		var panels;
		var panelIds = [];
		function toggle(e){
			items.removeClass(css);
			$(this).addClass(css);
			panels.hide();
			var panel = $(this).data('panel');
			if(panel){
				panel.show();
			}
			if (e) {
				e.preventDefault();
			}
			return false;
		}
		items.each(function (){
			var id = this.href.split('#')[1];
			var panel = $('#' + id);
			panelIds.push('#' + id);
			if($(this).hasClass(css)){
				panel.show();
			}else{
				panel.hide();
			}
			$(this).data('panel', panel);
			$(this).click(toggle);
		});
		panels = $(panelIds.join(','));
		ret = {
			toggle: function (id){
				items.each(function (){
					var aid = this.href.split('#')[1];
					if (aid == id) {
						toggle.call(this);
						return false;
					}
				})
			}
		};
		this.data('idTabs', ret);
	}
	if(id){
		ret.toggle(id);
	}
	return ret;
}
