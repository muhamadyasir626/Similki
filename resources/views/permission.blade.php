<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('css/permission.css') }}" rel="stylesheet">

  <title>Wait Permission</title>
</head>
<body style="display:flex; justify-content:center; align-content:center;">
  <img src="{{ asset('img/verifikasi.png') }}" alt="waiting permission" style="width: 50%; ">
  <script>
    window.onload = function(){
      fetch(`/api/check-permission`)
      .then((response)=> response.json())
      .then((data)=>{
        // console.log(data.status_permission);
        if(data.status_permission == '1'){
          window.location.href = '/dashboard';
        }
        
      })
    }
  </script>
</body>
</html>