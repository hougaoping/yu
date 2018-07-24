jQuery.message = function (opts){
   if (window.top !== window) {
       return window.top.jQuery.message(opts);
   }
   var el = jQuery.message.el;
   if (!el) {
       el = jQuery.message.el = $('<div class="message"></div>').appendTo(document.body);
       // el.css({"opacity":"0.90", "position":"fixed","top":0,"left":"0%","right":"0%","height":"44px", "border-bottom-left-radius":"0px", "border-bottom-right-radius":"0px", "line-height":"44px","background":"#0c9344","font-size":"16px","font-family": "Microsoft YaHei",color:"#fff","z-index":999999999,"text-align":"center"
       //});
   }
   if (typeof(opts) == 'string') {opts = {html: opts}}
   opts = $.extend({showHtml: $.noop}, opts);
   if(opts.type == 'success'){
      el.removeClass('error');
      el.addClass('success');
   }
   if(opts.type == 'error'){
      el.removeClass('success');
      el.addClass('error');
   }
   if (opts.css) {el.css(opts.css);}
   el.html(opts.html);
   var h = el.outerHeight()*1.5;
   if (opts.fx == 'fade') {
       el.fadeIn('fast');
   }else{
       el.css({top: -h});
       el.animate({top: 0});
   }
   function endCall(){
       if(opts.url){
           location.href = opts.url;
       }else if(opts.endCall){
           opts.endCall();
       }
   };
   var ret = {
       close: function (){
           clearInterval(jQuery.message.tid);
           if (opts.fx=='fade') {
               el.fadeOut('fast', endCall);
           }else{
               el.animate({
                   top: -h
               }, endCall);
           }
       }
   }
   clearInterval(jQuery.message.tid);
   var timeout =  opts.timeout || 2000;
   function loop(){
       if(timeout <= 0){
           ret.close();
       }else{
          opts.showHtml(el, Math.floor(timeout/1000));
       }
       timeout -= 1000;
   }
   jQuery.message.tid =setInterval(loop, 1000);
   loop();
   return ret;
};