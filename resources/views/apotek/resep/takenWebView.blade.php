@extends ('apotek.master2Apotek')
@section ('content')


<div class="ui text" style="margin-bottom:10%;padding-left:5%;padding-right:5%">
	<div style="padding-top:3%; padding bottom:0px; padding-top:0px">
	  <h1 class="ui dividing header" style="text-align:center">
	  	<div class="content" style="text-align:center">
	    	Resep Sudah Diambil
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
		      		<td>Biaya : <b>{{ $transaction->cost }}</td></b>
		      		<td>Durasi : <b>{{ $transaction->duration }} jam</td></b>
			    </tr>
			    <?php $i++;?>
		    @endforeach
		    @if($i==0)
		    	<br>
		    	<center><span class="center" style="text-align:center">Data Kosong</span></center><span style="text-align:center">Data Kosong</span>
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