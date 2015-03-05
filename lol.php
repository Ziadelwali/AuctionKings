<h2 style="font-weight: bold;font-size: 5em;">Timer:  <span id="timer"></span></h2>
<script>
var days = parseInt( countDownTime / 86400);
var hours = parseInt( countDownTime / 3600 ) % 24;
var minutes = parseInt( countDownTime / 60 ) % 60;
var seconds = countDownTime % 60;
var result = (days < 10 ? "0" + days : days) + ":" + (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);
	var countDownTime = 60;
	function countDownTimer() {
		var days = parseInt( countDownTime / 86400);
		var hours = parseInt( countDownTime / 3600 ) % 24;
		var minutes = parseInt( countDownTime / 60 ) % 60;
		var seconds = countDownTime % 60;
		var result = (days < 10 ? "0" + days : days) + ":" + (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);
		document.getElementById("timer").innerHTML = result;
   		if(countDownTime == 0 ){ countDownTime = 60*60*60; }
   		countDownTime = countDownTime - 1;
   		setTimeout(function(){ countDownTimer() }, 1000);
	}
	countDownTimer();
</script>