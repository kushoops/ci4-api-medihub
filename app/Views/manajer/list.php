<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Manajer List</h1>
  <hr>
  <a href="/manajer/register"><button>Tambah manajer</button></a>
  <br>
  <table id="table">
    <tr>
      <th>No</th>
      <th>Username</th>
      <th>Aksi</th>
    </tr>
  </table>
<script src="/cookies.js"></script>
<script>
  const table = document.querySelector('#table')
  fetch('http://localhost:8080/api/manajer/list', {
    headers: {'Authorization': 'Bearer ' + getCookie('token')},
    method: 'GET'
  })
  .then(res=>res.json())
  .then(data=>{
    if(data.status==false) {
      alert('Hanya Aministrator yang dapat melihat')
      window.location.replace('/')
    }else {
      let num = 0
      JSON.parse(JSON.stringify(data.data)).forEach(manajer => {

        const tdNo = document.createElement('td')
        tdNo.innerHTML = num+=1

        const tdUsername = document.createElement('td')
        tdUsername.innerHTML = manajer['username']!='' ? manajer['username'] : 'Tidak diketahui'

        const btnDelete = document.createElement('button')
        btnDelete.innerHTML = 'Delete'
        btnDelete.value = manajer['id']
        btnDelete.classList.add('delete')

        const tdAksi = document.createElement('td')
        tdAksi.appendChild(btnDelete)
        
        const tr = document.createElement('tr')
        tr.appendChild(tdNo)
        tr.appendChild(tdUsername)
        tr.appendChild(tdAksi)
        table.appendChild(tr)

        const btnDeletes = document.querySelectorAll('.delete')
        btnDeletes.forEach(btnDelete => {
          btnDelete.addEventListener('click', () => {
            fetch('http://localhost:8080/api/manajer/delete/' + btnDelete.value, {
              headers:{
                'Authorization': 'Bearer ' + getCookie('token')
              },
              method: 'DELETE'
            })
            .then(res=>res.json())
            .then(data=>{
              if(data.status==false) {
                alert('Data gagal dihapus')
              }else {
                alert('Data berhasil dihapus')
              }
              window.location.href.replace('/manajer/list')
            })
          })
        })
      })
    }})
</script>
</body>
</html>