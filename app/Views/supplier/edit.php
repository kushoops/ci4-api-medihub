<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Supplier</h1><span> edit</span>
  <hr>
  <a href="/supplier">profile</a>
  <br>
  <a href="/supplier/edit">edit profile</a>
  <br>
  <a href="/supplier/data-penunjang">data penunjang</a>
  <hr>
  <form id="form">
    <img id="image" src="" alt="">
    <br>
    <input id="old-avatar" type="hidden">
    <span>avatar</span><input id="avatar" type="file" accept=".jpg, .png">
    <br>
    <span>nama</span><input id="nama" type="text">
    <br>
    <span>alamat</span><input id="alamat" type="text">
    <br>
    <span>telp</span><input id="telp" type="text">
    <br>
    <button type="submit">Edit</button>
  </form>
<script src="/cookies.js"></script>
<script>
const form = document.querySelector('#form')
const image = document.querySelector('#image')

fetch('http://localhost:8080/api/supplier/profile', {
  headers: {
    'Authorization': 'Bearer ' + getCookie('token')
  }
})
.then(res=>res.json())
.then(data=>{
  if(data.status==false) {
    alert('Hanya Supplier yang dapat mengedit')
    window.location.replace('/')
  }else {
    const supplier = JSON.parse(JSON.stringify(data.data))
    image.src = supplier['avatar']!='' ? 'http://localhost:8080/images/suppliers/avatar/' + supplier['avatar'] : 'http://localhost:8080/images/suppliers/avatar/default.jpg'
    document.querySelector('#old-avatar').value = supplier['avatar']
    document.querySelector('#nama').value = supplier['nama']
    document.querySelector('#alamat').value = supplier['alamat']
    document.querySelector('#telp').value = supplier['telp']
  }
})

form.addEventListener('submit', e => {
  e.preventDefault()
  
  const oldAvatar = document.querySelector('#old-avatar').value
  const avatar = document.querySelector('#avatar').files[0]
  const nama = document.querySelector('#nama').value
  const alamat = document.querySelector('#alamat').value
  const telp = document.querySelector('#telp').value

  const formData = new FormData()
  formData.append('_method', "PUT")
  formData.append('old-avatar', oldAvatar)
  formData.append('avatar', avatar)
  formData.append('nama', nama)
  formData.append('alamat', alamat)
  formData.append('telp', telp)

  fetch('http://localhost:8080/api/supplier/update',  {
    headers: {
      'Authorization': 'Bearer ' + getCookie('token'),
    },
    method: 'POST',
    body: formData
  })
  .then(res=>res.json())
  .then(data=>data.status==true ? alert('Data berhasil diupdate') : alert('Data gagal diupdate'))
  .catch(err=>console.log(err))
})
</script>
</body>
</html>