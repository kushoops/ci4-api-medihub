<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>News List</h1>
  <hr>
  <a href="/news/add"><button>Tambah news</button></a>
  <br>
  <table id="table">
    <tr>
      <th>No</th>
      <th>Title</th>
      <th>Aksi</th>
    </tr>
  </table>
<script src="/cookies.js"></script>
<script>
const table = document.querySelector('#table')
fetch('http://localhost:8080/api/news/list')
.then(res=>res.json())
.then(data=>{
  let num = 0
  JSON.parse(JSON.stringify(data.data)).forEach(n => {
    const tdNo = document.createElement('td')
    tdNo.innerHTML = num+=1

    const tdTitle = document.createElement('td')
    tdTitle.innerHTML = n['title']

    const btnEdit = document.createElement('button')
    const a = document.createElement('a')
    btnEdit.innerHTML = 'Edit'
    a.appendChild(btnEdit)
    a.href = '/news/edit?id=' + n['id']

    const btnDelete = document.createElement('button')
    btnDelete.innerHTML = 'Delete'
    btnDelete.value = n['id']
    btnDelete.classList.add('delete')
    
    const tdAksi = document.createElement('td')
    tdAksi.appendChild(a)
    tdAksi.appendChild(btnDelete)
  
    const tr = document.createElement('tr')
    tr.appendChild(tdNo)
    tr.appendChild(tdTitle)
    tr.appendChild(tdAksi)
    table.appendChild(tr)

    const btnDeletes = document.querySelectorAll('.delete')
    btnDeletes.forEach(btnDelete => {
      btnDelete.addEventListener('click', () => {
        fetch('http://localhost:8080/api/news/delete/' + btnDelete.value, {
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
          window.location.href.replace('/news/list')
        })
      })
    })
  })
})
</script>
</body>
</html>