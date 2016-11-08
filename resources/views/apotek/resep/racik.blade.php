@extends ('apotek.masterApotek')
@section ('content')


<div class="ui text" style="margin-bottom:10%;padding-left:5%;padding-right:5%">
	<div style="padding-top:3%; padding bottom:0px; padding-top:0px">
	  <h1 class="ui dividing header">
	  	<i class="users icon" style="padding-bottom:5%"></i>
	  	<div class="content">
	    	Resep Diracik
	  	</div>
	  </h1>
	</div>
  <div style="padding:0%;padding-top:0px">
	  <div class="ui blue segment" style="height:80%">
		<table class="ui celled table segment table-hover" id="matkul">
		  <thead>
		    <tr>
		        <th width="5%" style="text-align:center">No</th>
		        <th width="10%" style="text-align:center">Dokter</th>
		        <th width="10%" style="text-align:center">Pasien</th>
	        	<th width="15%" style="text-align:center">Foto</th>
	        	<th width="20%" style="text-align:center">Pesan</th>
	        	<th width="10%" style="text-align:center">Biaya</th>
	        	<th width="10%" style="text-align:center">Lama racik</th>
	        	<th width="20%" style="text-align:center">Action</th>
	      	</tr>
	      </thead>
		  <tbody>
		  	<?php $i = 1?>
		  	@foreach ($transactions as $transaction)
			    <tr>
			      	<td class="center"><?php echo $i++ ?></td>
		      		<td>{{ $transaction->dokter->name }}</td>
		      		<td>{{ $transaction->user->name }}</td>
		      		<td><img src="{{url($transaction->photo)}}" style="width:30%"></td>
		      		<td><?php echo nl2br($transaction->message) ?></td>
		      		<td>{{ $transaction->cost }}</td>
		      		<td>{{ $transaction->duration }}</td>
		      		<td class="center" style="">
				      	<center>
					      	<a class="ui icon blue button" href="{{ URL::to('apotek/resep/selesai/'. $transaction->id) }}">
					        	<i class="pencil icon"></i>
					        	Selesai
					      	</a>
				      	</center>
			      	</td>
			    </tr>
		    @endforeach
		  </tbody>
		</table>
	  </div>
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