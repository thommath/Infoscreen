var nr = 5;
var text = [];
var textConfig = [];
var config;
var oldLength;
var running = false;
	function start(){
		update();
		startTime();
	}
	
	
	
	function update(){
		httpGetAsync("getRequest.php?nr=0", function(arr){//nyhet
												var json = arr,
												obj = JSON && JSON.parse(json) || $.parseJSON(json);
												text = obj;
												if(!running){startLoop();running = true;}
												});
		httpGetAsync("getRequest.php?nr=1", function(arr){//right
												var json = arr,
												obj = JSON && JSON.parse(json) || $.parseJSON(json);
												
												if(obj.length != oldLength){
													oldLength = obj.length;
													updatecss();
													document.getElementById('right').innerHTML = "";
													obj.forEach(function(entry){
														document.getElementById('right').innerHTML =  document.getElementById('right').innerHTML + "<div class=\"box\" id=\"right\">" + entry + "</div>";
													});
												}
												});
		httpGetAsync("getRequest.php?nr=2", function(arr){//bottom
												var json = arr,
												obj = JSON && JSON.parse(json) || $.parseJSON(json);
												document.getElementById('bottom').innerHTML = obj[obj.length-1];});
		httpGetAsync("getRequest.php?nr=3", function(arr){//css version
												var json = arr,
												obj = JSON && JSON.parse(json) || $.parseJSON(json);
												if(config == null){config = parseInt(obj);}
												else if(config != parseInt(obj)){updatecss();config = parseInt(obj);}});
	}
		
	function updatecss(){
		var newlink = document.createElement("link");
		newlink.setAttribute("rel", "stylesheet");
		newlink.setAttribute("type", "text/css");
		newlink.setAttribute("href", "style.php");
		document.getElementsByTagName("head").item(0).replaceChild(newlink, document.getElementsByTagName("link").item(0));
	}
	
	
	function startLoop(){
		update();
		if(nr >= text.length){nr -= text.length;}
		document.getElementById('left').style.opacity = 0;
		setTimeout(function(){
			document.getElementById('left').style.opacity = 1;
			if(text[nr][2] == 0){
				document.getElementById('left').innerHTML = "<div class=\"box\">" + text[nr][0] + "</div>";
			}else if(text[nr][2] == 1){
				image(text[nr][1]);
				document.getElementById('left').innerHTML = "<div id=\"imagebox\" class=\"imagebox\" style=\"background-image: url('" + text[nr][1] + "');\">" + text[nr][0] + "</div>";
			}else if(text[nr][2] == 2){
				image(text[nr][1]);
				document.getElementById('left').innerHTML = "<div id=\"imagebox\" class=\"imagebox\" style=\"background-image: url('" + text[nr][1] + "');\"></div>";
			}
			},500);
		setTimeout(function(){startLoop(nr++);},text[nr][3]);
	}
	
	function image(imgsrc){
		var newImg = new Image();
		newImg.onload = function(){
			var obj = document.getElementById("imagebox");
	//		alert(document.getElementById("content").offsetWidth + " " + document.getElementById("content").offsetHeight
	//		+ "\n" + newImg.width + " " + newImg.height);
			if(document.getElementById("content").offsetWidth >= newImg.width && document.getElementById("content").offsetHeight >= newImg.height){
				obj.style.width = newImg.width;
				obj.style.height = newImg.height;
				
			}else if(document.getElementById("content").offsetWidth >= newImg.width && document.getElementById("content").offsetHeight < newImg.height){
					obj.style.height = document.getElementById("content").offsetHeight;
					obj.style.width = document.getElementById("content").offsetHeight*(newImg.width/newImg.height);
					
			}else if(document.getElementById("content").offsetWidth < newImg.width && document.getElementById("content").offsetHeight >= newImg.height){
				obj.style.width = document.getElementById("content").offsetWidth;
				obj.style.height = document.getElementById("content").offsetWidth*(newImg.height/newImg.width);
				
			}else if(document.getElementById("content").offsetWidth < newImg.width && document.getElementById("content").offsetHeight < newImg.height){
				if(	newImg.height - document.getElementById("content").offsetHeight <= newImg.width-document.getElementById("content").offsetWidth){
						obj.style.width = document.getElementById("content").offsetWidth;
						obj.style.height = document.getElementById("content").offsetWidth*(newImg.height/newImg.width);
					}else{
						obj.style.height = document.getElementById("content").offsetHeight;
						obj.style.width = document.getElementById("content").offsetHeight*(newImg.width/newImg.height);
					}
			}
			
	//		alert(document.getElementById("content").offsetWidth + " " + document.getElementById("content").offsetHeight
	//		+ "\n" + obj.style.width + " " + obj.style.height);
			
//			alert(newImg.height + " " + newImg.width);
		}
		newImg.src = imgsrc;
	}

	function startTime() {
		var mn = ["Januar", "Februar", "Mars", "April", "Mai", "Juni", "juli", "August", "September", "Oktober", "November", "Desember"];
		var today=new Date();
		var d=today.getDate();
		var mo=today.getMonth();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById('clock').innerHTML = h+":"+m + "<div style=\"font-size:0.5em;\">"+d+" "+mn[mo]+"</div>";
		
		var t = setTimeout(function(){startTime()},500);
	}
	function checkTime(i) {
		if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
		return i;
	}

	function httpGetAsync(theUrl, callback){
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.onreadystatechange = function() { 
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
				callback(xmlHttp.responseText);
		}
		xmlHttp.open("GET", theUrl, true); // true for asynchronous 
		xmlHttp.send(null);
	}