try {
    $("<link>").attr({href: "//live2d-cdn.fghrsh.net/assets/1.4.2/waifu.min.css", rel: "stylesheet", type: "text/css"}).appendTo('head');
    $.ajax({url: '//live2d-cdn.fghrsh.net/assets/1.4.2/waifu-tips.min.js', dataType:"script", cache: true, success: function() {
            $.ajax({url: '//live2d-cdn.fghrsh.net/assets/1.4.2/live2d.min.js', dataType:"script", cache: true, success: function() {
                    live2d_settings['modelId'] = 5;                  // 榛樿妯″瀷 ID
                    live2d_settings['modelTexturesId'] = 1;          // 榛樿鏉愯川 ID
                    live2d_settings['modelStorage'] = false;         // 涓嶅偍瀛樻ā鍨  ID
                    initModel('assets/waifu-tips.json');
                }});
        }});
} catch(err) { console.log('[Error] JQuery is not defined.') }