<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Informatics Support System | Login</title>
            <script src="https://cdn.tailwindcss.com"></script>
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

                0%,
                100% {
                    transform: translateX(0);
                }

                10%,
                30%,
                50%,
                70%,
                90% {
                    transform: translateX(-5px);
                }

                20%,
                40%,
                60%,
                80% {
                    transform: translateX(5px);
                }
            }
            </style>
        </head>

        <body class="gradient-bg min-h-screen flex items-center justify-center p-4">
            <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-indigo-700 py-6 px-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">Informatics Support System</h1>
                            <p class="text-indigo-200 text-sm mt-1">Access your support dashboard</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-full">
                            <i class="fas fa-lock text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="px-8 py-8">
                    <form id="loginForm" class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="username" name="username"
                                    class="input-focus pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition duration-200"
                                    placeholder="Enter your username" required>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password"
                                    class="input-focus pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition duration-200"
                                    placeholder="Enter your password" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePassword"
                                        class="text-gray-400 hover:text-indigo-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                Sign in
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm">
                        <p class="text-gray-600">Don't have an account? <a href="#"
                                class="font-medium text-indigo-600 hover:text-indigo-500">Contact support</a></p>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle password visibility
                const togglePassword = document.getElementById('togglePassword');
                const password = document.getElementById('password');

                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                        '<i class="fas fa-eye-slash"></i>';
                });

                // Form submission with validation
                const loginForm = document.getElementById('loginForm');

                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const username = document.getElementById('username').value;
                    const password = document.getElementById('password').value;

                    // Simple validation
                    if (username.trim() === '' || password.trim() === '') {
                        loginForm.classList.add('shake');
                        setTimeout(() => {
                            loginForm.classList.remove('shake');
                        }, 500);

                        alert('Please fill in all fields');
                        return;
                    }

                    // Here you would typically send the data to a server
                    console.log('Login attempt with:', {
                        username,
                        password
                    });

                    // Simulate successful login
                    alert('Login successful! Redirecting...');
                    // window.location.href = 'dashboard.html';
                });

                // Remove shake class after animation
                loginForm.addEventListener('animationend', function() {
                    this.classList.remove('shake');
                });
            });
            </script>
        </body>

        </html>
    </form>
</x-guest-layout>