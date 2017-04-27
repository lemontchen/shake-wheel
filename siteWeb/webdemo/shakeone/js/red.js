 $(document).ready(function() {
 	var count=0;
	if (window.DeviceMotionEvent){
		var speed = 25;
	 	var audio = document.getElementById("shakemusic");
		var openAudio = document.getElementById("openmusic");
		var x = t = z = lastX = lastY = lastZ = 0;
		window.addEventListener('devicemotion',
			function () {
				var acceleration = event.accelerationIncludingGravity;
				x = acceleration.x;
				y = acceleration.y;
				if (Math.abs(x - lastX) > speed || Math.abs(y - lastY) > speed) {
					audio.play();
					$('.red-ss').addClass('wobble');
					setTimeout(function(){
						//随机抽取手机号手机号
						var phone = ['135****8827','137****1621','135****5498']; 
						var index = Math.floor((Math.random()*phone.length)); 
						var user= phone[index];
						/*需要抽取手机号的个数count*/
						if (count<5) {
						audio.pause();
						openAudio.play();
						$('#user').html(user); 
						$('.red-tc').css('display', 'block'); 
						$('#nochance').css('display', 'none');
						}else{
						$('.red-tc').css('display', 'block'); 
						$('#userout').css('display', 'none');
						$('#nochance').css('display', 'block');
						} 
					}, 1500);
				};
				lastX = x;
				lastY = y;
			},false);
	};
	var list=[];
	$('#go').tap(function(){
	var userphone=$('#user').html();
	count =list.push(userphone);
	if (count==1) {
		$('#count').html("<span>第"+count+"位中奖者"+userphone+"</span></br>");
	}else{
		$('#count').append("<span>第"+count+"位中奖者"+userphone+"</span></br>");	
	}
    $('#list').css('height',count*40+"px");
	$('.red-tc').css('display', 'none');
	 })
	$('#home').tap(function(){
	$('.red-tc').css('display', 'none');
	  })
});