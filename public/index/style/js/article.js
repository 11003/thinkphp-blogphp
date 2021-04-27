$(function() {
  hljs.initHighlightingOnLoad(); //代码高亮
  //回复按钮点击事件
  $('#blog-comment').on('click', '.btn-reply',
    function() {
      var targetId = $(this).data('targetid'),
        targetName = $(this).data('targetname'),
        $container = $(this).parent('.date').parents().siblings('.replycontainer');
      if ($(this).text() == '回复') {
        $container.find('textarea').attr('placeholder', '回复【' + targetName + '】');
        $container.removeClass('layui-hide');
        $container.find('input[name="mid"]').val(targetId);
        $container.find('input[name="uName"]').val(targetName);
        $(this).parents('.blog-comment li').find('.btn-reply').text('回复');
        $(this).text('收起');
      } else {
        $container.addClass('layui-hide');
        $container.find('input[name="mid"]').val(0);
        $container.find('input[name="uName"]').val(0);
        $(this).text('回复');
      }
    });
  //左侧导航栏
  var mobile_flag = isMobile();

  if (!mobile_flag) {
    $("#zoom").children().each(function(index, element) {
      var tagName = $(this).get(0).tagName;
      if (tagName.substr(0, 1).toUpperCase() == "H") {
        var substrTagName = tagName.substr(1, 1);
        var dis = HContentMarginLeft(substrTagName);
        var contentH = $(this).text(); //获取内容
        if (contentH != '') {
          var markid="mark-"+tagName+"-"+index.toString();
          // var markid = contentH.replace(/ /g, "-");
          $(this).attr("id", markid); //为当前h标签设置id
          $(".menu").append("<li><a style='margin-left: " + dis + "px' href='#" + markid + "'>" + contentH + "</a></li>").show(); //在目标DIV中添加内容
        }
      }
    });
    // 滚动
    var header_wrap = $("#header_wrap").outerHeight();//头部的距离
    var rightNav = $("#menu-box");
    $(window).on('scroll', function () {
      var cur_pos = $(this).scrollTop();

      $(":header").each(function() {
        var top = $(this).offset().top - header_wrap,
          bottom = top + $(this).outerHeight();
        if (cur_pos >= top && cur_pos <= bottom) {
          rightNav.find('li').removeClass('active');
          rightNav.find('a[href="#'+$(this).attr('id')+'"]').parent("li").addClass('active');
        }
      });
    });
  }
  $(".menu-close").click(function(){
    $(this).siblings("li").slideToggle();
  });
  function isMobile() {
    var userAgentInfo = navigator.userAgent;

    var mobileAgents = ["Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod"];

    var mobile_flag = false;

    //根据userAgent判断是否是手机
    for (var v = 0; v < mobileAgents.length; v++) {
      if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
        mobile_flag = true;
        break;
      }
    }
    var screen_width = window.screen.width;
    var screen_height = window.screen.height;

    //根据屏幕分辨率判断是否是手机
    if (screen_width < 500 && screen_height < 800) {
      mobile_flag = true;
    }

    return mobile_flag;
  }
  function HContentMarginLeft(tagName) {
    let content = "";
    switch (tagName) {
      case "2":
        content = "10"
        break;
      case "3":
        content = "25"
        break;
      case "4":
        content = "30"
        break;
      case "5":
        content = "40"
        break;
      case "6":
        content = "45"
        break;
      case "7":
        content = "50"
        break;
      default:
        content = "0"
    }
    return content;
  }
  // 添加active
  $(".menu li [href!='#']").click(function() {
    var var_href = $(this).attr("href");
    $('.active').removeClass('active');
    $(this).parent('li').addClass('active');

    $('.pt3em').removeClass('pt3em');
    $(var_href).addClass('pt3em');
  });
  // $(".menu [href!='#']").click(function() {
  //   var var_href = $(this).attr("href");
  //   if (var_href.length) {
  //     var len_href = var_href.length
  //   }
  //   var has_mao = var_href.search("#");
  //   if (has_mao == -1) return;
  //   var index_mao = var_href.lastIndexOf("#");
  //   var sub_href = var_href.substr(index_mao, len_href - index_mao);
  //   $('html,body').animate({
  //       scrollTop: $(sub_href).offset().top - 35
  //     },
  //     150);
  //   return false;
  // });
  //导航栏拖动
  var posX;
  var posY;

  fwuss = document.getElementById("menu-box");
  fwuss.onmousedown = function(e) {
    posX = event.x - fwuss.offsetLeft; //获得横坐标x
    posY = event.y - fwuss.offsetTop; //获得纵坐标y
    document.onmousemove = mousemove; //调用函数，只要一直按着按钮就能一直调用
  }
  document.onmouseup = function() {
    document.onmousemove = null; //鼠标举起，停止
  }

  function mousemove(ev) {
    if (ev == null) ev = window.event; //IE
    fwuss.style.left = (ev.clientX - posX) + "px";
    fwuss.style.top = (ev.clientY - posY) + "px";
  }
  //给内容区图片添加a标签
  $("#zoom").find('img').each(function() {
    var str = "<a href='" + this.src + "' target='_blank'></a>";
    $(this).wrapAll(str);
  });

  $(".comments_wrap").find('img').each(function() {
    var str = "<a href='" + this.src + "' target='_blank'></a>";
    $(this).wrapAll(str);
  });
  var allpre = document.getElementsByTagName("pre");
  for (var i = 0; i < allpre.length; i++) {
    var onepre = document.getElementsByTagName("pre")[i];
    var mycode = document.getElementsByTagName("pre")[i].innerHTML;
    onepre.innerHTML = '<code class="mycode">' + mycode + '</code>';
  }
});

$("#user_like").click(function() {
  if ($(this).is('.unlike')) {
    layer.msg('您已经点过赞了！感谢您的支持。', {
      anim: 6
    });
    return;
  }
  $("#user_like").removeClass('like shake shake-hard');
  var aid = $(this).attr('aid');
  var cid = $(this).attr('cid');
  $.ajax({
    url: "/like/" + aid + "/" + cid,
    type: 'POST',
    dataType: "json",
    success: function(res) {
      if (res.status == 1) {
        var click = $(".votecount").text();

        $("#user_like").addClass('unlike');

        click++;
        $(".votecount").html(click);
        layer.msg(res.msg, {
          anim: 7
        });
      } else {
        layer.msg(res.msg, {
          anim: 5
        });
      }
    }
  });
});
function back() {
  layer.confirm('确定要退出吗？退出后要重新填写您的信息!', {
      icon: 3,
      title: '提示'
    },
    function(index) {
      $.getJSON("/logout",
        function(res) {
          if (res.status == 1) {
            layer.msg(res.msg, {
              icon: 1
            });
            setTimeout(function() {
                window.parent.location.reload();
              },
              800)
          } else {
            layer.msg(res.msg, {
              anim: 6
            });

          }
        })
    });
}