var timeleft = 60;
var Timer = setInterval(function(){
  if(timeleft <= 0){
    timeleft = 60
  } else {
    document.getElementById("timer").innerHTML = timeleft + " second(s)";
  }
  timeleft -= 1;
}, 1000);