<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Supplier List</h1>
  <hr>
  <table id="table">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Jenis</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </table>
<script src="/cookies.js"></script>
<script>
  const table = document.querySelector('#table')
  fetch('http://localhost:8080/api/supplier/list', {
    headers: {'Authorization': 'Bearer ' + getCookie('token')},
    method: 'GET'
  })
  .then(res=>res.json())
  .then(data=>{
    if(data.status==false) {
      alert('Hanya Manajer atau Aministrator yang dapat melihat')
      window.location.replace('/')
    }else {
      let num = 0
      JSON.parse(JSON.stringify(data.data)).forEach(supplier => {

        const tdNo = document.createElement('td')
        tdNo.innerHTML = num+=1

        const tdNama = document.createElement('td')
        tdNama.innerHTML = supplier['nama']!='' ? supplier['nama'] : 'Tidak diketahui'

        const tdTetap = document.createElement('td')
        tdTetap.innerHTML = supplier['tetap']==true ? 'Tetap' : 'Non Tetap'

        const tdStatus = document.createElement('td')
        tdStatus.innerHTML = supplier['pengajuan']==true ? 'Mengajukan' : ''

        const btnDetail = document.createElement('button')
        btnDetail.innerHTML = 'Detail'
        const a = document.createElement('a')
        a.href = '/supplier/detail?id=' + supplier['supplier_id']
        a.appendChild(btnDetail)

        const btnDelete = document.createElement('button')
        btnDelete.innerHTML = 'Delete'
        btnDelete.value = supplier['supplier_id']
        btnDelete.classList.add('delete')

        const tdAksi = document.createElement('td')
        tdAksi.appendChild(a)
        tdAksi.appendChild(btnDelete)
        
        const tr = document.createElement('tr')
        tr.appendChild(tdNo)
        tr.appendChild(tdNama)
        tr.appendChild(tdTetap)
        tr.appendChild(tdStatus)
        tr.appendChild(tdAksi)
        table.appendChild(tr)

        const btnDeletes = document.querySelectorAll('.delete')
        btnDeletes.forEach(btnDelete => {
          btnDelete.addEventListener('click', () => {
            fetch('http://localhost:8080/api/supplier/delete/' + btnDelete.value, {
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
              window.location.href.replace('/supplier/list')
            })
          })
        })
      })
    }})
</script>
</body>
</html>