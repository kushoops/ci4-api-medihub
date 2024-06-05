<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>News Edit</h1>
  <hr>
  <form id="form">
    <img id="preview" src="" alt="">
    <input id="old-image" type="hidden">
    <br>
    <span>image : </span><input id="image" type="file">
    <br>
    <span>title : </span><input id="title" type="text">
    <br>
    <span>description : </span><input id="description" type="text">
    <br>
    <button type="submit">edit</button>
  </form>
<script src="/cookies.js"></script>
<script>
const form = document.querySelector('#form')
const preview = document.querySelector('#preview')

const url = new URL(window.location.href)
const params = new URLSearchParams(url.search);
const id = params.get('id')

fetch('http://localhost:8080/api/news/single/' + id, {
  headers: {
    'Authorization': 'Bearer ' + getCookie('token')
  }
})
.then(res=>res.json())
.then(data=>{
  if(data.status==false) {
    alert('Hanya Administrator yang dapat mengedit')
    window.location.replace('/')
  }else {
    const supplier = JSON.parse(JSON.stringify(data.data))
    preview.src = supplier['image']!='' ? 'http://localhost:8080/images/news/' + supplier['image'] : ''

    document.querySelector('#old-image').value = supplier['image']
    document.querySelector('#title').value = supplier['title']
    document.querySelector('#description').value = supplier['description']

    form.addEventListener('submit', e => {
      e.preventDefault()
      
      const oldImage = document.querySelector('#old-image').value
      const image = document.querySelector('#image').files[0]
      const title = document.querySelector('#title').value
      const description = document.querySelector('#description').value

      const formData = new FormData()
      formData.append('_method', "PUT")
      formData.append('old-image', oldImage)
      formData.append('image', image)
      formData.append('title', title)
      formData.append('description', description)

      fetch('http://localhost:8080/api/news/update/' + id,  {
        headers: {
          'Authorization': 'Bearer ' + getCookie('token'),
        },
        method: 'POST',
        body: formData
      })
      .then(res=>res.json())
      .then(data=>data.status==true ? alert('News berhasil diupdate') : alert('News gagal diupdate'))
      .catch(err=>console.log(err))
    })
  }
})
</script>
</body>
</html>