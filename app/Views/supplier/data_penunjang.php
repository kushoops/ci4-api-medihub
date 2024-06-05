<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Supplier</h1><span> data penunjang</span>
  <hr>
  <a href="/supplier">profile</a>
  <br>
  <a href="/supplier/edit">edit profile</a>
  <br>
  <a href="/supplier/data-penunjang">data penunjang</a>
  <hr>
  <form id="form">
    <input id="old-data" type="hidden">
    <span>data pendukung</span><input id="data" type="file" accept=".pdf">
    <br>
    <button type="submit">Upload</button>
  </form>
  <br>
  <!-- <button>Mengajukan menjadi supplier tetap</button> -->
<script src="/cookies.js"></script>
<script>
  const form = document.querySelector('#form')
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

    document.querySelector('#old-data').value = supplier['data']

    const iframe = document.createElement('iframe')
    iframe.src = 'http://localhost:8080/images/suppliers/data/' + supplier['data']
    supplier['data']!='' ? document.body.appendChild(iframe) : ''

    document.body.appendChild(document.createElement('br'))
    document.body.appendChild(document.createElement('br'))
      
    const btn = document.createElement('button')
    btn.innerHTML = 'Mengajukan menjadi pegawai tetap'
    btn.id = 'btn'
    supplier['tetap']==false ? document.body.appendChild(btn) : ''

    document.querySelector('#btn').addEventListener('click', () => {
      fetch('http://localhost:8080/api/supplier/update', {
        headers: {
          'Authorization': 'Bearer ' + getCookie('token'),
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        method: 'POST',
        body: '_method=PUT&pengajuan=1'
      })
      .then(res=>res.json())
      .then(data=>data.status==true ? alert('Berhasil mengajukan') : alert('Gagal mengajukan'))
    })
  }
})

form.addEventListener('submit', e => {
  e.preventDefault()
  
  const oldData = document.querySelector('#old-data').value
  const data = document.querySelector('#data').files[0]

  const formData = new FormData()
  formData.append('_method', "PUT")
  formData.append('old-data', oldData)
  formData.append('data', data)

  fetch('http://localhost:8080/api/supplier/update',  {
    headers: {
      'Authorization': 'Bearer ' + getCookie('token'),
    },
    method: 'POST',
    body: formData
  })
  .then(res=>res.json())
  .then(data=>data.status==true ? alert('Data berhasil diupload') : alert('Data gagal diupload'))
  .catch(err=>console.log(err))
})
</script>
</body>
</html>