@extends ('apotek.master2Apotek')
@section ('content')
<meta charset="utf-8">
<div style="">
  <h1 class="ui dividing header">
    <div class="content" >
      Terima Resep
    </div>
  </h1>
  <br>
  <div class="ui grid stackable" style="margin-bottom:10%;">
    <div  class="sixteen wide column">
        <form class="ui form" action="" method="post"  enctype="multipart/form-data">
          <div visible>
            <div id="form1" >
              <div class="sixteen wide field">
                    <label>Dokter : {{$transaction->dokter->name}}</label>
              </div>
              <div class="sixteen wide field">
                    <label>Pasien : {{$transaction->user->name}}</label>
              </div>
              <div class="sixteen wide field">
                   <label>Resep</label>
                  <div class="fourteen wide field">
                    <center><img src="data:image/png;base64,<?php echo $transaction->photo?>" style="width:110%"/></center>
                  </div>
              </div>
              <div class="sixteen wide field">
                   <label>Pesan : <?php echo ($transaction->message)?></label>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Biaya</label>
                  </div>
                  <div class="fourteen wide field">
                    <input type="number" name="cost" placeholder="Biaya">
                  </div>
                </div>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Lama Peracikan (dalam jam)</label>
                  </div>
                  <div class="fourteen wide field">
                    <input type="number" name="duration" placeholder="Lama Peracikan">
                  </div>
                </div>
              </div>
              {{csrf_field()}}
              <div class="ui error message"></div>
              <center>
	              <button class="ui icon red button" type="submit">
	                Kirim
	              </button>
              </center>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
  
<script type="text/javascript">
  $('select.dropdown')
  .dropdown(); 
</script>

@endsection