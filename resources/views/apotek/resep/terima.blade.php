@extends ('apotek.masterApotek')
@section ('content')
<meta charset="utf-8">
<div style="padding-left:20%;padding-right:20%;">
  <h1 class="ui dividing header">
    <i class="users icon" style="padding-bottom:5%"></i>
    <div class="content" >
      Update Resep
    </div>
  </h1>
  <br>
  <div class="ui grid stackable" style="margin-bottom:10%;">
    <div  class="sixteen wide column">
      <div class="ui blue segment" style="padding-bottom:5%">
        <form class="ui form" action="" method="post"  enctype="multipart/form-data">
          <div visible>
            <div id="form1" >
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Dokter</label>
                  </div>
                  <div class="fourteen wide field">
                    <input type="text" name="user" placeholder="ID Pasien" value="{{$transaction->dokter->name}}" readonly="">
                  </div>
                </div>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Pasien</label>
                  </div>
                  <div class="fourteen wide field">
                    <input type="text" name="user" placeholder="ID Pasien" value="{{$transaction->user->name}}" readonly="">
                  </div>
                </div>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Foto</label>
                  </div>
                  <div class="fourteen wide field">
                    <img src="{{url($transaction->photo)}}" style="width:30%" readonly="">
                  </div>
                </div>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Pesan</label>
                  </div>
                  <div class="fourteen wide field">
                    <textarea type="text" name="message" readonly=""><?php echo ($transaction->message)?></textarea>
                  </div>
                </div>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Biaya</label>
                  </div>
                  <div class="fourteen wide field">
                    <input type="text" name="cost" placeholder="Biaya">
                  </div>
                </div>
              </div>
              <div class="sixteen wide field">
                <div class="inline fields">
                  <div class="two wide field">
                    <label>Lama Peracikan</label>
                  </div>
                  <div class="fourteen wide field">
                    <input type="text" name="duration" placeholder="Lama Peracikan">
                  </div>
                </div>
              </div>
              {{csrf_field()}}
              <div class="ui error message"></div>
              <button class="ui icon green button" type="submit">
                Kirim
                <i class="save icon"></i>
              </button>
            </div>
          </div>
        </form>
        <br>
      </div>
    </div>
  </div>
</div>
  
<script type="text/javascript">
  $('select.dropdown')
  .dropdown(); 
</script>

<!-- <script src="{{URL::to('assets/js/moment.min.js')}}"></script>
<script src="{{URL::to('assets/js/angular.min.js')}}"></script>
<script src="{{URL::to('assets/plugin/datepicker/dist/ng-flat-datepicker.js')}}"></script>
<script src="{{URL::to('assets/plugin/datepicker/demo/js/app.js')}}"></script> -->

@endsection