<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <div class="flow-root bg-gray-100 p-6 rounded-lg">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Bienvenido, {{$user}}</h3>
        <p class="text-gray-600 mb-4">Se ha creado una cuenta nueva. Actívala.</p>
        <a href="{{$url}}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
            Activar Cuenta
        </a>
    </div>
</body>
</html>