@extends ('apotek.master2Apotek')
@section ('content')


<div class="ui text" style="margin-bottom:10%;padding-left:5%;padding-right:5%">
	<div style="padding-top:3%; padding bottom:0px; padding-top:0px">
	  <h1 class="ui dividing header" style="text-align:center">
	  	<div class="content" style="text-align:center">
	    	Resep Diterima
	  	</div>
	  </h1>
	</div>
  <div style="padding:0%;padding-top:0px">

		<table class="ui celled table segment table-hover" id="matkul">
		  <tbody>
		  	@foreach ($transactions as $transaction)
			    <tr>
		      		<td>Dokter : <b>{{ $transaction->dokter->name }}</b></td>
		      		<td>Pasien : <b>{{ $transaction->user->name }}</b></td>
		      		<!-- <td  style="text-align:center"><img src="data:image/png;base64,<?php echo $transaction->photo?>" /></td> -->
		      		<td>Catatan : <b><?php echo nl2br($transaction->message) ?></b></td>
		      		<td class="center" style="">
				      	<center>
					      	<a class="ui icon red button" href="{{ URL::to('webview/apotek/resep/terima/'. $transaction->id.'/'.$transaction->apotek->remember_token) }}">
					        	Terima
					      	</a>
				      	</center>
			      	</td>
			    </tr>
		    @endforeach
		  </tbody>
		</table>
  </div>
</div>


<script type="text/javascript">
	function dele(id){
        $('#modaldiv').modal('show');
        $('.button_modal').attr({href:id});
	};

</script>
<script> 
  $(function () {
    $("#matkul").DataTable();
        });
</script>
@endsection