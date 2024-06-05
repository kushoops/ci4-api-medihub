<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Login</h1>
  <hr>
  <form id="form">
    <span>email</span><input type="email" name="email" required>
    <br>
    <span>password</span><input type="password" name="password" required>
    <br>
    <button>login</button>
  </form>
<script src="/cookies.js"></script>
<script>
const form = document.querySelector('#form')
form.addEventListener('submit', (e) => {
  e.preventDefault()
  const formData = new FormData(form)
  const data = new URLSearchParams(formData)
  fetch('http://localhost:8080/api/login', {
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    method: 'POST',
    body: data
  })
  .then(res=>res.json())
  .then(data=>{
    if(data.status == false) {
      alert('Login gagal')
    }else {
      setCookie('token', data.data.token, 1)
      alert('Login berhasil')
      window.location.replace('/')
    }
  })
  .catch(error=>console.log(error))
})
</script>
</body>
</html>