@extends ('apotek.master2Apotek')
@section ('content')


<div class="ui text" style="margin-bottom:10%;padding-left:5%;padding-right:5%">
	<div style="padding-top:3%; padding bottom:0px; padding-top:0px">
	  <h1 class="ui dividing header" style="text-align:center">
	  	<div class="content" style="text-align:center">
	    	Resep Sedang Diracik
	  	</div>
	  </h1>
	</div>
  <div style="padding:0%;padding-top:0px">

		<table class="ui celled table segment table-hover" id="matkul">
		  <tbody>
		  	<?php $i = 0;?>
		    @foreach ($transactions as $transaction)
			    <tr>
		      		<td>Dokter : <b>{{ $transaction->dokter->name }}</td></b>
		      		<td>Pasien : <b>{{ $transaction->user->name }}</td></b>
		      		<td>Resep :</td></b>
		      		<td style="text-align:center"><img src="data:image/png;base64,<?php echo $transaction->photo?>" style="width:100%"> </td></b>
		      		<td >Catatan : <b><?php echo nl2br($transaction->message) ?></td></b>
		      		<form class="ui form" action="{{url('webview/apotek/racik/'.$transaction->id.'/'.$transaction->apotek->remember_token)}}" method="post">
			      		<td>Biaya : <input name="cost" value="{{ $transaction->cost }}" type="number"></td>
			      		<td>Durasi : <input name="duration" value="{{ $transaction->duration }}"  type="number"> jam</td></b> 
		      		
			      		<td class="center" style="">
					      	<center>
						      	<button class="ui icon green button" type="submit">
						        	Update
						      	</button>
					      	</center>
				      	</td>
			      	</form>
		      		<td class="center" style="">
				      	<center>
					      	<a class="ui icon red button" href="{{ URL::to('webview/apotek/resep/selesai/'. $transaction->id.'/'.$transaction->apotek->remember_token) }}">
					        	Selesai
					      	</a>
				      	</center>
			      	</td>
			    </tr>
			    <?php $i++;?>
		    @endforeach
		    @if($i==0)
		    	<br>
		    	<center><span class="center" style="text-align:center">Data Kosong</span></center>
		    @endif
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