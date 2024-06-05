<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Tambah News</h1>
  <hr>
  <form id="form">
    <span>image</span><input id="file" type="file" accept=".jpg, .png" name="image">
    <br>
    <span>title</span><input id="title" type="text" name="title" required>
    <br>
    <span>description</span><input id="description" type="text" name="description" required>
    <br>
    <button type="submit">Tambah</button>
  </form>
<script src="/cookies.js"></script>
<script>
const form = document.querySelector('#form')
form.addEventListener('submit', e => {
  e.preventDefault()

  const image = document.querySelector('#file').files[0]
  const title = document.querySelector('#title').value
  const description = document.querySelector('#description').value

  const formData = new FormData()
  formData.append('image', image)
  formData.append('title', title)
  formData.append('description', description)


  fetch('http://localhost:8080/api/news/add',  {
    headers: {
      'Authorization': 'Bearer ' + getCookie('token'),
    },
    method: 'POST',
    body: formData
  })
  .then(res=>res.json())
  .then(data=>data.status==true ? alert('News berhasil ditambahkan') : alert('News gagal ditambahkan'))
  .catch(err=>console.log(err))
})
</script>
</body>
</html>