<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Bank Sampah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-green-600">
                    Bank Sampah
                </h1>

                <p class="text-gray-500 mt-2">
                    Sistem Informasi Bank Sampah
                </p>

            </div>

            @if(session('status'))

                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">

                    {{ session('status') }}

                </div>

            @endif

            <form
                method="POST"
                action="{{ route('login') }}"
                class="space-y-5">

                @csrf

                {{-- EMAIL --}}

                <div>

                    <label
                        class="block text-sm font-medium mb-2">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus

                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-green-200">

                    @error('email')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                {{-- PASSWORD --}}

                <div>

                    <label
                        class="block text-sm font-medium mb-2">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        required

                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-green-200">

                    @error('password')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                {{-- REMEMBER --}}

                <div class="flex items-center">

                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="rounded">

                    <label
                        for="remember"
                        class="ml-2 text-sm text-gray-600">

                        Remember Me

                    </label>

                </div>

                {{-- BUTTON --}}

                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold">

                    Login

                </button>

            </form>

        </div>

        <p class="text-center text-sm text-gray-500 mt-4">

            © {{ date('Y') }} Bank Sampah

        </p>

    </div>

</body>
</html>