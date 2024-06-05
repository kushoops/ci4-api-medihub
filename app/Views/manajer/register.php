<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Manajer Register</h1>
  <hr>
  <form id="form">
    <span>username</span><input type="text" name="username" required>
    <br>
    <span>email</span><input type="email" name="email" required>
    <br>
    <span>password</span><input type="password" name="password" required>
    <br>
    <button>register</button>
  </form>
<script src="/cookies.js"></script>
<script>
const form = document.querySelector('#form')
form.addEventListener('submit', (e) => {
  e.preventDefault()
  const formData = new FormData(form)
  const data = new URLSearchParams(formData)
  fetch('http://localhost:8080/api/manajer/register', {
    headers: {
      'Authorization': 'Bearer ' + getCookie('token'),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    method: 'POST',
    body: data
  })
  .then(res=>res.json())
  .then(data=>data.status==true ? alert('Register berhasil') : alert('Register gagal'))
  .catch(err=>console.log(err))
})
</script>
</body>
</html>