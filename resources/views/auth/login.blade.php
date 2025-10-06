<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="email" name="email" id="email" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="password">Password</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="password" name="password" id="password" required>
            </div>
            <button class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600" type="submit">Login</button>
        </form>
    </div>
</body>
</html>