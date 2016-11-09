
<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properities -->
  <title>Login</title>
  @include('header')
  @include('footer')

  <style type="text/css">
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
  <script>
  $(document)
    .ready(function() {
      $('.ui.form')
        .form({
          fields: {
            email: {
              identifier  : 'username',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your username'
                },
              ]
            },
            password: {
              identifier  : 'password',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your password'
                },
              ]
            },
            nrp: {
              identifier  : 'nrp',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your NRP'
                },
              ]
            }
          }
        })
      ;
    })
  ;
  </script>
</head>
<body>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <img src="{{URL::to('assets/image/logo.png')}}" style="width:80%" class="image">
      <div class="content" style="color:#b4312f ">
      
        Log-in to your account
      </div>
    </h2>
    <form class="ui large form" action="{{url('login')}}" method="POST">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="Username">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        {{csrf_field()}}
        <div class="ui fluid large teal submit button" style="background-color:#b4312f ">Login</div>
      </div>

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      Don't have account ?
      <a onclick="forget('')" href="#" style="background-color:rgba(0,0,0,0);color:#46a3db">
        Register here!
      </a>
    </div>
  </div>
</div>

</body>
<div class="ui inverted test small first coupled modal" id="modalForget">
  <form id="formForget" class="ui form" action="{{url('register')}}" method="post">
    <div class="ui center aligned icon dividing header" style="margin:2%">
        <i class="user icon"></i>
        <div class="content">
          Register
        </div>
    </div>
    <div class="content">
      <div class="centered container">
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>Email</label>
          </div>
          <div class="ten wide field">
            <input type="text" name="username" placeholder="NRP" />
            <div class="ui error message"></div>
          </div>
        </div>
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>Password</label>
          </div>
          <div class="ten wide field">
            <input type="password" name="password" placeholder="Password" />
            <div class="ui error message"></div>
          </div>
        </div>
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>Nama Lengkap</label>
          </div>
          <div class="ten wide field">
            <input type="text" name="name" placeholder="Nama Lengkap"/>
            <div class="ui error message"></div>
          </div>
        </div>
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>No Telp</label>
          </div>
          <div class="ten wide field">
            <input type="text" name="telp" placeholder=">No Telp" />
            <div class="ui error message"></div>
          </div>
        </div>
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>NIP / KTP / No Ijin Praktek</label>
          </div>
          <div class="ten wide field">
            <input type="text" name="nip" placeholder="NIP / KTP / No Ijin Praktek"/>
            <div class="ui error message"></div>
          </div>
        </div>
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>Alamat</label>
          </div>
          <div class="ten wide field">
            <input type="text" name="address" placeholder="Alamat" />
            <div class="ui error message"></div>
          </div>
        </div>
        <div class="sixteen wide field">
          <div class="ten wide field">
            <label>Role</label>
          </div>
          <div class="ten wide field">
            <select type="text" name="role" placeholder="Alamat" />
              <option value="2">Pasien</option>
              <option value="3">Dokter</option>
              <option value="4">Apotek</option>
            </select>
            <div class="ui error message"></div>
          </div>
        </div>
        <br>
      </div>
    </div>
    <div class="actions">
      <div class="ui red deny button ">Cancel</div>
      <a class="ui positive button blue " id="buttonSubmit">Submit</a>
    </div>
    {{csrf_field()}}
  </form>
</div>

<div class="ui small second coupled modal" id="secondModal">
  <div class="header">
    Kode Verifikasi telah dikirim ke Email Anda
  </div>
  <div class="content">
    <div class="description">
      <p>Silahkan cek email Anda untuk mendapatkan kode verifikasi guna mengubah password Anda</p>
    </div>
  </div>
  <div class="actions">
    <button class="ui approve blue button submit" onclick="submit()" id="submit">
      <i class="checkmark icon"></i>
      Next
    </button>
    
  </div>
</div>
  

<script type="text/javascript">
  $('#formForget input').keydown(function (e) {
      if (e.keyCode == 13) {
          var inputs = $(this).parents("form").eq(0).find(":input");
          if (inputs[inputs.index(this) + 1] != null) {                    
              inputs[inputs.index(this) + 1].focus();
          }
          e.preventDefault();
          return false;
      }
  });
  $('#submit').keydown(function (e) {
      if (e.keyCode == 13) {
          var inputs = $(this).parents("form").eq(0).find(":input");
          if (inputs[inputs.index(this) + 1] != null) {                    
              inputs[inputs.index(this) + 1].focus();
          }
          e.preventDefault();
          return false;
      }
  });
  function forget(){
        $('#modalForget')
        .modal({blurring: true})
        .modal('setting', 'closable', false)
        .modal('show');

  };

  $('#buttonSubmit').click(function (e){
    if ($.trim($('#nrp').val()) == '')
    {
      $('#formForget').submit();
      return false;
    }
    else
    {
      $('.second.modal')
      .modal('attach events', '.first.modal .button')
      .modal('setting', 'closable', false)
      .modal('show');
    }
  });


  function submit()
  {
    $('#formForget').submit();
  };

  $('.coupled.modal')
    .modal({
      allowMultiple: false
  });
</script>
<?php 
if(Session::has('status') && Session::get('status') == 'success'){
        echo '<script language="javascript">';
        echo 'swal("Berhasil!", "Password berhasil diubah!", "success");';
        echo '</script>';
  }

else if(Session::has('status') && Session::get('status') == 'not-in-state'){
        echo '<script language="javascript">';
        echo 'swal("Gagal!", "Anda belum merequest pergantian password!", "error");';
        echo '</script>';
  }

else if(Session::has('status') && Session::get('status') == 'wrong-code'){
        echo '<script language="javascript">';
        echo 'swal("Gagal!", "Kode yang Anda masukkan salah!", "error");';
        echo '</script>';
  }
else if(Session::has('status') && Session::get('status') == 'failed'){
        echo '<script language="javascript">';
        echo 'swal("Gagal!", "Gagal mengubah password!", "error");';
        echo '</script>';
  }
else if(Session::has('status') && Session::get('status') == 'not-exist'){
        echo '<script language="javascript">';
        echo 'swal("Gagal!", "NRP yang Anda masukkan tidak terdaftar!", "error");';
        echo '</script>';
  }
else if(Session::has('status') && Session::get('status') == 'dont-have-right'){
        echo '<script language="javascript">';
        echo 'swal("Gagal!", "Anda tidak berhak mengganti password!", "error");';
        echo '</script>';
  }
else if(Session::has('status') && Session::get('status') == 'failed-login'){
      echo '<script language="javascript">';
      echo 'swal("Gagal!", "Password atau username salah", "error");';
      echo '</script>';
}
else if(Session::has('status') && Session::get('status') == 'register-success'){
      echo '<script language="javascript">';
      echo 'swal("Sukses!", "Register berhasil", "success");';
      echo '</script>';
}
else if(Session::has('status') && Session::get('status') == 'register-failed'){
      echo '<script language="javascript">';
      echo 'swal("Gagal!", "Username sudah ada", "error");';
      echo '</script>';
}
?>
</html>
