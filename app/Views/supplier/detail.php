<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Supplier Detail</h1>
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
  <br>
  <span>begabung sejak : </span><span id="created_at"></span>
  <br>
  <span>data pendukung : </span>
  <br>
<script src="/cookies.js"></script>
<script>
const avatar = document.querySelector('#avatar')
const nama = document.querySelector('#nama')
const alamat = document.querySelector('#alamat')
const telp = document.querySelector('#telp')
const jenis = document.querySelector('#jenis')
const created_at = document.querySelector('#created_at')
const data = document.querySelector('#data')

const url = new URL(window.location.href)
const params = new URLSearchParams(url.search);
const id = params.get('id')

fetch('http://localhost:8080/api/supplier/single/' + id, {
  headers: {
    'Authorization': 'Bearer ' + getCookie('token')
  }
})
.then(res=>res.json())
.then(data=>{
  if(data.status==false) {
    alert('Hanya Manajer atau Administrator yang dapat melihat')
    window.location.replace('/')
  }else {
    const supplier = JSON.parse(JSON.stringify(data.data))
    avatar.src = supplier['avatar']!='' ? 'http://localhost:8080/images/suppliers/avatar/' + supplier['avatar'] : 'http://localhost:8080/images/suppliers/avatar/default.jpg'
    nama.innerHTML = supplier['nama']
    alamat.innerHTML = supplier['alamat']
    telp.innerHTML = supplier['telp']
    tetap.innerHTML = supplier['tetap']!=false ? 'Tetap' : 'Non Tetap'
    created_at.innerHTML = supplier['created_at']

    const iframe = document.createElement('iframe')
    iframe.src = 'http://localhost:8080/images/suppliers/data/' + supplier['data']
    const span = document.createElement('span')
    span.innerHTML = 'Data kosong'
    supplier['data']!='' ? document.body.appendChild(iframe) : document.body.appendChild(span)

    document.body.appendChild(document.createElement('br'))
    document.body.appendChild(document.createElement('br'))

    const btn = document.createElement('button')
    btn.innerHTML = 'Terima menjadi pegawai tetap'
    btn.id = 'btn'
    supplier['tetap']==false ? document.body.appendChild(btn) : ''

    document.querySelector('#btn').addEventListener('click', () => {
      fetch('http://localhost:8080/api/supplier/accept/' + id, {
        headers: {
          'Authorization': 'Bearer ' + getCookie('token'),
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        method: 'POST',
        body: '_method=PUT&pengajuan=0&tetap=1'
      })
      .then(res=>res.json())
      .then(data=>data.status==true ? alert('Berhasil diterima') : alert('Gagal diterima'))
    })
  }
})
</script>
</body>
</html>