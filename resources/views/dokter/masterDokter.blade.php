<!DOCTYPE html>

<html lang="en">
<link rel="icon" type="image/png" href="{{URL::to('assets/image/logo.png')}}">
@include('header')
@include('footer')	
@include('dokter.navDokter')
<body class="hold-transition skin-blue fixed sidebar-mini">
	<div class="wrapper">
		
		<div class="content-wrapper">
			@yield('content')
		</div>
    </div>
</body>
<!-- <div class="ui inverted vertical footer segment" style="margin-top:10%">
    <div class="ui container">
      <div class="ui stackable inverted divided equal height stackable grid">
        <div class="sixteen wide column">
          <h4 class="ui inverted header" style="float:right">&copy; 2016 |Algorithm and Programming Laboratory</h4>
        </div>
      </div>
    </div>
 </div> -->
</html>
