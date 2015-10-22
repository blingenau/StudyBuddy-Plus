function randomNum() {
  var x = Math.floor((Math.random() * 255) + 0);
  return x;
}  
function hexFromRGB(r, g, b) {
  var hex = [
    r.toString( 16 ),
    g.toString( 16 ),
    b.toString( 16 )
  ];
  $.each( hex, function( nr, val ) {
    if ( val.length === 1 ) {
      hex[ nr ] = "0" + val;
    }
  });
  return hex.join( "" ).toUpperCase();
}
function refreshSwatch() {
  var red = $( "#red" ).slider( "value" ),
    green = $( "#green" ).slider( "value" ),
    blue = $( "#blue" ).slider( "value" ),
    hex = hexFromRGB( red, green, blue );
    $( "#swatch" ).css( "background-color", "#" + hex );
    $("#hexNum").html("Hex of current color:#" + hex);
}
function refreshSample() {
  var specs = new Array();
  var numR = randomNum();
  specs.push(numR);
  var numG = randomNum();
  specs.push(numG);
  var numB = randomNum();
  specs.push(numB);
  var hex = hexFromRGB( numR, numG, numB );
  $( "#sample" ).css( "background-color", "#" + hex );
  return specs;
}   

function getTime() {
  var start_time = new Array();
  var oDate =new Date;
  start_time.push(oDate.getHours());
  start_time.push(oDate.getMinutes());
  start_time.push(oDate.getSeconds());
  start_time.push(oDate.getMilliseconds());
  return start_time;
}   

function getScore( numR, numG, numB, diff, start_time, stop_time ) {
  var time_taken = stop_time[3]+stop_time[2]*1000+stop_time[1]*60000+stop_time[0]*3600000-(start_time[3]+start_time[2]*1000+start_time[1]*60000+start_time[0]*3600000);
  var score = calculateScore( numR, numG, numB, time_taken, diff );
  if (score < 0) {
    score = 0;
  }
  $("#score").html( "Last Try Score: " + score );
  return score;
} 

function calculateScore( numR, numG, numB, time, diff ) {
  var inputR = $( "#red" ).slider( "value" );
  var inputG = $( "#green" ).slider( "value" );
  var inputB = $( "#blue" ).slider( "value" );
  var perOffR = Math.abs( numR - inputR)/255*100; 
  var perOffG = (Math.abs(numR - inputR)/255*100);
  var perOffB = (Math.abs(numR - inputR)/255*100);
  var perOff = (perOffB + perOffG + perOffR)/3;
  var score = (15 - diff - perOff)/(15-diff)*(15000-time);
  //alert( "actual:" + numR + " "  + numG + " " + numB + "\ninput:" + inputR + " " + inputG + " " +inputB + "\nperoff spec:" + perOffR + " " + perOffG + " " + perOffB + "\npercentage off: " + perOff + "\ntime: " + time + "\nscore: " + score );
  return Math.round(score);
}




//main
$(function() {
//clear the input automatically when user want to type
  $("#turns").click(function () {
    $(this).val('');            
  });
//record the turn value when "focusout" event triggered, default is 10 
  var totalRounds = 10;
  $("#turns").focusout(function () {
    if ($(this).val() != '' && $.isNumeric($(this).val())) {
      totalRounds = Math.round($(this).val());
    }
  });
//record the diffcult when "change" event triggered, default is 5
  var diff = 5;
  $("#difficulty").change(function () {
    diff = $(this).val();
  });
//initialize the game  
  $( "#red, #green, #blue" ).slider({
    orientation: "horizontal",
    range: "min",
    max: 255,
    value: 127,
    slide: refreshSwatch,
    change: refreshSwatch
  });
  $( "#red" ).slider( "value", 10 );
  $( "#green" ).slider( "value", 10 );
  $( "#blue" ).slider( "value", 10 );
  $( "#speed" ).selectmenu();
  var round = 0; //current round
  var colorSpecs = new Array();
  var start_time = new Array();
  var totalScore = 0;
//when the start button is clicked
  var oStart = document.getElementById("start");
  oStart.onclick = function () {
    round = 0;
    totalScore = 0;
    $("#roundInfo").html( "Round "+ (round+1) + " of " + totalRounds );
    start_time = getTime();
    colorSpecs = refreshSample();
    $("#btn").css("display","inline");
    $("#start").css("display","none");
  };

//when the check button is clicked
  var oBtn = document.getElementById("btn");
  oBtn.onclick = function () {
    if ((round+1) < totalRounds) {
      round ++;
      var stop_time = getTime();
      var lastScore = getScore( colorSpecs[0], colorSpecs[1], colorSpecs[2], diff, start_time, stop_time );
      colorSpecs = refreshSample();
//reset the color slider
      $( "#red" ).slider( "value", 10 );
      $( "#green" ).slider( "value", 10 );
      $( "#blue" ).slider( "value", 10 );
      start_time = getTime();
      totalScore += lastScore;
      $("#totalScore").html("Total Score: " + totalScore);
      $("#roundInfo").html( "Round "+ (round+1) + " of " + totalRounds );
    } else {
      var stop_time = getTime();
      var lastScore = getScore( colorSpecs[0], colorSpecs[1], colorSpecs[2], diff, start_time, stop_time );
      alert("game over!!!\n Your total score is: " + totalScore);
      $("#start").html("play agian!");
      $("#start").css("display","inline");
      $("#btn").css("display","none");
      $( "#red" ).slider( "value", 10 );
      $( "#green" ).slider( "value", 10 );
      $( "#blue" ).slider( "value", 10 );
    }
  }; 
});