function getCookieVal (offset) {
   var endstr = document.cookie.indexOf (";", offset);
   if (endstr == -1) endstr = document.cookie.length;
   return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie (name) {
   var arg = name + "=";
   var alen = arg.length;
   var clen = document.cookie.length;
   var i = 0;
   while (i < clen) {	//while open
      var j = i + alen;
      if (document.cookie.substring(i, j) == arg)
         return getCookieVal (j);
      i = document.cookie.indexOf(" ", i) + 1;
      if (i == 0) break; 
   }	//while close
   return null;
}

function SetCookie (name, value) {
   var argv = SetCookie.arguments;
   var argc = SetCookie.arguments.length;
   var expires = (2 < argc) ? argv[2] : null;
   var path = (3 < argc) ? argv[3] : null;
   var domain = (4 < argc) ? argv[4] : null;
   var secure = (5 < argc) ? argv[5] : false;
   document.cookie = name + "=" + escape (value) +
      ((expires == null) ? "" : 
         ("; expires=" + expires.toGMTString())) +
      ((path == null) ? "" : ("; path=" + path)) +
      ((domain == null) ? "" : ("; domain=" + domain)) +
      ((secure == true) ? "; secure" : "");
} 

var activity_id = GetCookie('latest_activity_id');

var sNotify = {
	
	timeOpen: 3,	//change this number to the amount of second you want the message opened
	
	queue: new Array(),
	closeQueue: new Array(),
	
	addToQueue: function(msg) {
		sNotify.queue.push(msg);
	},
	
	alterNotifications: function(msg) {
		console.log(msg);
		$.ajax({ url: 'http://zipoo.iptime.org:8080/kgns/member/activity/' + msg,
        type: 'post',
        
        success: function(output) {
        			var jsonobj = JSON.parse(output);
        			if(parseInt(output) == parseInt(activity_id))
        				return;
        			for(var i=0; i<jsonobj.length; i++)
        			{
        				var notice_text = jsonobj[i].user_name + "님이 " + jsonobj[i].activity_type;
        				sNotify.queue.push(notice_text); 
        			}
                 	
                 	//activity_id = parseInt(output);
                 	//SetCookie('latest_activity_id', parseInt(output));
                },
        error: function(response) {
        	console.log(response)
        }
		});
	},
	/* Single time alerts fro the notifications Added By Anil on 18th March 2011 */
	
	createMessage: function(msg) {
		
		//create HTML + set CSS
		var messageBox = $("<div class=\"sNotify_block\" ><span class=\"sNotify_close\"></span>" + msg + "</div>").prependTo("body");
		$(messageBox).addClass("sNotify_message");
		
		sNotify.enableActions(messageBox);
		sNotify.closeQueue.push(0);
		
		return $(messageBox);
		
	},
	
	loopQueue: function() {
		//pop queue
		if (sNotify.queue.length > 0) {
			
			var messageBox = sNotify.createMessage(sNotify.queue[0]);
			sNotify.popMessage(messageBox);
			
			sNotify.queue.splice(0,1);
			
		}
		
		//close queue
		if (sNotify.closeQueue.length > 0) {
			var indexes = new Array();
			
			for (var i = 0; i < sNotify.closeQueue.length; i++) {
				sNotify.closeQueue[i]++;
				
				if (sNotify.closeQueue[i] > sNotify.timeOpen) {
					indexes.push(i);
				}
			}
			
			//now close them
			for (var i = 0; i < indexes.length; i++) {
				var buttons = $(".sNotify_close");
				sNotify.closeMessage($(buttons[($(buttons).length - indexes[i]) - 1]));
				sNotify.closeQueue.splice(indexes[i],1);	
			}
			
		}
		
	},
	
	enableActions: function(messageBox) {
		//reset timer when hovering
		$(messageBox).hover(
			function() {
				var index = ($(this).nextAll().length - 1);
				sNotify.closeQueue[index] = -1000;
			},
			function() {
				var index = ($(this).nextAll().length - 1);
				sNotify.closeQueue[index] = 0;
			}
		);
		
		//enable click close button
		$(messageBox).find(".sNotify_close").click(function() {
			sNotify.closeMessage(this);
		});
	},
	
	popMessage: function(messageBox) {
		$(messageBox).css({
			marginRight: "-290px",
			opacity: 0.2,
			display: "block"
		});
		
		/*var height = parseInt($(messageBox).outerHeight()) + parseInt($(messageBox).css("margin-bottom"));
		
		$(".sNotify_message").next().each(function() {
			var topThis = $(this).css("top");
			
			if (topThis == "auto") {
				topThis = 0;
			}
			
			var newTop = parseInt(topThis) + parseInt(height);
			
			$(this).animate({
				top: newTop + "px"
			}, {
				queue: false,
				duration: 600
			});
		});*/
		
		$(messageBox).animate({
			marginRight: "20px",
			opacity: 1.0
		}, 800);
	},
	
	closeMessage: function(button) {
		var height = parseInt($(button).parent().outerHeight()) + parseInt($(button).parent().css("margin-bottom"));
		
		$(button).parent().nextAll().each(function() {
			var topThis = $(this).css("top");
			
			if (topThis == "auto") {
				topThis = 0;
			}
			
			var newTop = parseInt(topThis) - parseInt(height);
			
			$(this).animate({
				top: newTop + "px"
			}, {
				queue: false,
				duration: 300
			});
		});
		
		$(button).parent().hide(200, function() {
			$(this).remove();
		});
	}
		
}

setInterval("sNotify.loopQueue()", 900);