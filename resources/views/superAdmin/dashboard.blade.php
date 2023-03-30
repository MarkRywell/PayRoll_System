<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
   <div class="w-screen h-screen">
        <nav class="bg-blue-400 w-screen p-6 fixed top-0 left-0 right-0">
            <div class="flex justify-center ">
                <img src="{{ asset('image/logo.png') }}" alt="" class="h-[22px] px-6 object-contain">
            </div>
        </nav>
        <div class="h-screen w-72 bg-white drop-shadow-2xl xl:hidden" id='menu'>
                
        </div>
   </div>
   
</body>

</html>