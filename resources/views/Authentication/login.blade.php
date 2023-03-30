<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
  <div class="w-screen h-screen">
    <div class="h-[40%] bg-sky-400 min-w-screen flex justify-center">
        <div class="flex flex-col items-center h-full w-screen gap-10">
            <div class="bg-bglogo w-[200px] h-[200px] object-contain mt-10 flex items-center">
                <img src="{{ asset('image/logo.png') }}" alt="" class="bg-bglogo">
            </div>
            <div class="flex h-screen items-center">
                <div class="h-[360px] max-w-[400px] w-screen bg-white rounded-md shadow-2xl">
                    <div class="flex flex-col items-center gap-8">
                        <h1 class="font-semibold mt-[20px] text-2xl">Sign In</h1>
                        <p class="text-gray-400 text-sm">Sign in with your username and password</p>
                    </div>
                    <form action="#" method="post">
                        <div class="div flex flex-col gap-6 mt-[20px]">
                            <div class="border-2 border-black mx-5 rounded-md h-[40px] flex items-center">
                                <input type="email" name="email" id="email" placeholder="Email" class="w-full px-4 h-full">
                            </div>
                            <div class="border-2 border-black mx-5 rounded-md h-[40px] flex items-center">
                                <input type="password" name="password" id="password" placeholder="Password" class="px-4 w-full h-full">
                            </div>
                            <div class="flex justify-center h-[40px] bg-blue-500 mx-5 rounded-sm text-white font-medium hover:bg-blue-200 hover:cursor-pointer">
                                <button type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
  </div>
</body>
</html>