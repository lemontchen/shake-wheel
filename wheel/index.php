<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta name="description" content="微信">
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">    
        <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="0">
        <title> 幸运大转盘</title>
        <link href="activity-style2.css" rel="stylesheet" type="text/css">
    </head>
    <body class="activity-lottery-winning" >
        <div id="loader" style="text-align: center;height:30px;line-height: 30px;background: white;display: none;"><img src="load.gif" align="absmiddle"/> 请稍后，数据传输中 ...</div>
        <div  class="main"  >
            <script src="jquery.min.js" type="text/javascript"></script> 
            <div id="outercont">
                <div id="outer-cont">
                    <div id="outer"><img src="zp8-.png"></div>
                </div>
                <div id="inner-cont">
                    <div id="inner"><img src="activity-lottery-2.png"></div>
                </div>
                <div class="boxcontent boxwhite">
                    <div class="box">
                        <div class="title-red">活动说明：</div>
                        <div class="Detail">
                            <p >本次活动仅限现场朋友参与！</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            $(function() {
                window.requestAnimFrame = (function() {
                    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
                            function(callback) {
                                window.setTimeout(callback, 1000 / 60)
                            }
                })();
                var totalDeg = 360 * 3 + 0;
                var steps = [];

                //var lostDeg = [120, 240, 360];
                //var prizeDeg = [40, 80, 160, 200, 280, 320];
				var lostDeg = [120, 240, 360];//未中奖区域
                var prizeDeg = [40, 80, 160, 200, 280, 320];//中奖区域
                var prize, sncode;
                var count = 0;
                var now = 0;
                var a = 0.01;
                var outter, inner, timer, running = false;
                function countSteps() {
                    var t = Math.sqrt(2 * totalDeg / a);
                    var v = a * t;
                    for (var i = 0; i < t; i++) {
                        steps.push((2 * v * i - a * i * i) / 2)
                    }
                    steps.push(totalDeg)
                }
                function step() {
                    outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
                    outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
                    if (now < steps.length) {
                        running = true;
                        requestAnimFrame(step)
                    } else {
                        running = false;
                    }
                }
                function start(deg) {
                    deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
                    running = true;
                    clearInterval(timer);
                    totalDeg = 360 * 5 + deg;
                    steps = [];
                    now = 0;
                    countSteps();
                    requestAnimFrame(step);
                }
                window.start = start;
                outter = document.getElementById('outer');
                inner = document.getElementById('inner');
                i = 10;
                $("#inner").click(function() {

                    if (running)
                        return;
                    
                    $('#loader').show();
                    $('#inner-cont').css('top', '148px');
                    
                    $.get('ajax.php?app=lottery_json',function(rid){
                        $('#loader').hide();
                        $('#inner-cont').css('top', '118px');
                       if (rid == 0){
                            start();
                        }else{
                            start(prizeDeg[rid - 1]);
                        }
                    });  
                });
            });
        </script>
    </body>
</html>
