<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome Message</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <!-- Outer Container with exact border styling -->
    <div class="relative w-full max-w-3xl">
        <!-- Main Container with rounded border -->
        <div class="bg-gray-900 border border-gray-500 rounded-[2rem] px-20 py-24 relative">
            <!-- Welcome Message -->
            <div class="text-center mb-16">
                <h1 class="text-gray-300 text-6xl font-light mb-6 tracking-wide" style="font-weight: 300;">Welcome to Our Platform</h1>
                <p class="text-gray-500 text-xl font-light">Connect, share, and discover amazing content with our community</p>
            </div>
            
            <!-- Buttons Container -->
            <div class="flex justify-center gap-12">
                <!-- Login Button -->
                <a href="{{ route('login.form') }}" 
                   class="bg-transparent border border-gray-500 text-gray-300 px-16 py-4 rounded-2xl hover:bg-gray-800 hover:border-gray-400 transition-all duration-200 text-xl font-light tracking-wide">
                    Login
                </a>
                
                <!-- Register Button -->
                <a href="{{ route('register.form') }}" 
                   class="bg-transparent border border-gray-500 text-gray-300 px-14 py-4 rounded-2xl hover:bg-gray-800 hover:border-gray-400 transition-all duration-200 text-xl font-light tracking-wide">
                    Register
                </a>
            </div>
        </div>
    </div>
</body>
</html>