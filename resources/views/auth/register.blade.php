<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Register Akun Baru</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="name">Nama</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" name="name" id="name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="email" name="email" id="email" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="password" name="password" id="password" required>
            </div>
            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600" type="submit">Register</button>
        </form>
    </div>
</body>
</html>                                         