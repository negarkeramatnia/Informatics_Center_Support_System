<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Informatics Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.5);
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Register Card -->
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Header -->
    <div class="bg-indigo-700 py-6 px-8 text-white rounded-t-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Informatics Support System</h1>
                <p class="text-indigo-200 text-sm mt-1">Create your account</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
        </div>
    </div>


        <!-- Register Form -->
        <div class="px-8 py-8">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="name" name="name" required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg"
                        placeholder="Enter a unique username">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email"
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg"
                        placeholder="Enter a unique email">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="phone" name="phone"
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="role" required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg">
                        <option value="user" selected>User</option>
                        <option value="support">Support</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Profile Picture -->
                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture"
                        class="w-full border border-gray-300 rounded-lg p-2">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm">
                <p class="text-gray-600">Already have an account? 
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Login
                    </a>
                </p>
            </div>
    </div>
    </div>

</body>
</html>