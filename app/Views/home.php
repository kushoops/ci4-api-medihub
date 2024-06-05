<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Home</h1>
    <hr>
    <a href="/register">register</a>
    <br>
    <a href="/login">login</a>
    <br>
    <a href="/supplier">supplier</a>
    <br>
    <a href="/supplier/list">list supplier</a>
    <br>
    <a href="/manajer">list manajer</a>
    <br>
    <a href="/news">list news</a>
    <hr>
    <div id="news"></div>
<script>
  const news = document.querySelector('#news')
  fetch('http://localhost:8080/api/news/list')
  .then(res=>res.json())
  .then(data=>{
    let num = 0
    JSON.parse(JSON.stringify(data.data)).forEach(n => {
      const img = document.createElement('img')
      img.src = 'images/news/' + n['image']
      const h3 = document.createElement('h3')
      h3.innerHTML = n['title']
      const p = document.createElement('p')
      p.innerHTML = n['description']

      news.appendChild(img)
      news.appendChild(h3)
      news.appendChild(p)
    })

  })
</script>
</body>
</html>