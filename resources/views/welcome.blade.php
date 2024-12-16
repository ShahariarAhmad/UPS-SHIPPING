<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script src="https://cdn.tailwindcss.com"></script>
       
    </head>
    <body>

        <div class="flex items-center justify-center min-h-screen">
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
              Click to Generate a Dummy Shipping
            </a>
          </div>
          
    </body>
</html>
