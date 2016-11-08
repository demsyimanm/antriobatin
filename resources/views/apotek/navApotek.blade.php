<style type="text/css">
.clock {width:800px; margin:0 auto; padding:30px; border:1px solid #333; color:#fff; }

#Date { font-size:12px;color:white; }

ul .date{  margin:0 auto; padding:0px; list-style:none;color:white;list-style-type: none; font-size:16px;}
ul li .date1{ display:inline; font-size:16px;color:white;display: inline; margin: auto}

#point { position:relative; -moz-animation:mymove 1s ease infinite; -webkit-animation:mymove 1s ease infinite; padding-left:10px; padding-right:10px; }

@-webkit-keyframes mymove 
{
0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
50% {opacity:0; text-shadow:none; }
100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }  
}


@-moz-keyframes mymove 
{
0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
50% {opacity:0; text-shadow:none; }
100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }  
}

</style>
<script type="text/javascript">
function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

$(document).ready(function() {

  var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
  var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
   <?php date_default_timezone_set('Asia/Jakarta'); // CDT?>
  var newDate = new Date('<?php print date("F d, Y H:i:s", time())?>');
  
  function setTime(){
    newDate.setSeconds(newDate.getSeconds() + 1);
    newDate.setDate(newDate.getDate());
    $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

    
    var seconds = newDate.getSeconds();
    $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
    
    var minutes = newDate.getMinutes();
    $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);

    var hours = newDate.getHours();
    $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
  };
  setInterval(setTime, 1000);
}); 
</script>

<style>
  body {
    padding-top: 6em;
  }
  .ui.menu {
    margin: 3em 0em;
  }
  .ui.menu:last-child {
    margin-bottom: 110px;
  }
  </style>

  <!--- Example Javascript -->
  <script>
  $(document)
    .ready(function() {
      $('.ui.menu .ui.dropdown').dropdown({
        on: 'hover'
      });
      $('.ui.menu a.item')
        .on('click', function() {
          $(this)
            .addClass('active')
            .siblings()
            .removeClass('active')
          ;
        })
      ;
    })
  ;
  </script>

<div class="ui fixed menu" style="box-shadow: 0px 3px 3px 0 rgba(187,16,21,1);">
 <div class="ui container">
    <div class="header item">
      <img class ="logo" src="{{URL::to('assets/image/logo.png')}}" style="60%"> <a href="{{url('/')}}"></a>
    </div>
    <a class="item" href="{{url('/')}}">Home</a>
    <a class="item" href="{{url('apotek/resep')}}">Resep Masuk</a>
    <a class="item" href="{{url('apotek/racik')}}">Resep Diracik</a>
    <a class="item" href="{{url('apotek/selesai')}}">Obat Bisa Diambil</a>
    <a class="item" href="{{url('apotek/taken')}}">Obat Sudah Diambil</a>
    
    <div class="right menu">
      <div class="item"  style="float:left">
        <ul class="date" style="margin-bottom:0px">
          <li id="hours" class="date1" style="display:inline;color:black"> </li>
          <li id="point" class="date1" style="display:inline;color:black">:</li>
          <li id="min" class="date1" style="display:inline;color:black"> </li>
          <li id="point"class="date1" style="display:inline;color:black">:</li>
          <li id="sec"class="date1" style="display:inline;color:black"> </li>
        </ul>  
      </div>
      <div class="item" style="margin-left:10%;margin-right:10%">
        <p>Hi, {{Auth::user()->name}}!</p>
      </div>
      <div class="ui dropdown item">
        Profile
        <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item" href="{{url('profile')}}">Edit Profile</a>
          <a class="item" href="{{url('logout')}}">Logout</a>
        </div>
      </div>
      <!-- <div id="Date" class="item"></div> -->
      
    </div>
  </div>
  
</div>