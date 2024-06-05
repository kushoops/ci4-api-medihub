<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Supplier</h1><span> profile</span>
  <hr>
  <a href="/supplier">profile</a>
  <br>
  <a href="/supplier/edit">edit profile</a>
  <br>
  <a href="/supplier/data-penunjang">data penunjang</a>
  <hr>
  <img id="avatar" src="" alt="">
  <br>
  <span>nama : </span><span id="nama"></span>
  <br>
  <span>alamat : </span><span id="alamat"></span>
  <br>
  <span>telp : </span><span id="telp"></span>
  <br>
  <span>jenis pegawai : </span><span id="tetap"></span>
<script src="/cookies.js"></script>
<script>
const avatar = document.querySelector('#avatar')
const nama = document.querySelector('#nama')
const alamat = document.querySelector('#alamat')
const telp = document.querySelector('#telp')
const jenis = document.querySelector('#jenis')

fetch('http://localhost:8080/api/supplier/profile', {
  headers: {
    'Authorization': 'Bearer ' + getCookie('token')
  }
})
.then(res=>res.json())
.then(data=>{
  if(data.status==false) {
    alert('Hanya Supplier yang dapat melihat')
    window.location.replace('/')
  }else {
    const supplier = JSON.parse(JSON.stringify(data.data))
    avatar.src = supplier['avatar']!='' ? 'http://localhost:8080/images/suppliers/avatar/' + supplier['avatar'] : 'http://localhost:8080/images/suppliers/avatar/default.jpg'
    nama.innerHTML = supplier['nama']
    alamat.innerHTML = supplier['alamat']
    telp.innerHTML = supplier['telp']
    tetap.innerHTML = supplier['tetap']!=false ? 'Tetap' : 'Non Tetap'
  }
})
</script>
</body>
</html>