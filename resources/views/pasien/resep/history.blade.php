@extends ('pasien.masterPasien')
@section ('content')


<div class="ui text" style="margin-bottom:10%;padding-left:5%;padding-right:5%">
	<div style="padding-top:3%; padding bottom:0px; padding-top:0px">
	  <h1 class="ui dividing header">
	  	<i class="users icon" style="padding-bottom:5%"></i>
	  	<div class="content">
	    	Riwayat Penyakit 
	  	</div>
	  </h1>
	</div>
  <div style="padding:0%;padding-top:0px">
	  <div class="ui blue segment" style="height:80%">
		<table class="ui celled table segment table-hover" id="matkul">
		  <thead>
		    <tr>
		        <th width="5%" style="text-align:center">No</th>
            <th width="15%" style="text-align:center">Penyakit</th>
		        <th width="10%" style="text-align:center">Dokter</th>
	        	<th width="20%" style="text-align:center">Tahun</th>
	        	<th width="20%" style="text-align:center">Deskripsi</th>
	      	</tr>
	      </thead>
		  <tbody>
		  	<?php $i = 1?>
		  	@foreach ($histories as $history)
			    <tr>
			      	<td class="center"><?php echo $i++ ?></td>
              <td>{{ $history->illness }}</td>
		      		<td>{{ $history->dokter->name }}</td>
		      		<td>{{$history->year}}</td>
		      		<td><?php echo nl2br($history->description)?></td>
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