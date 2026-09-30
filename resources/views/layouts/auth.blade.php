<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Library Management System')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex">

        {{-- Left side --}}
        <div class="hidden lg:flex lg:w-1/2 bg-primary-700 relative overflow-hidden">

            <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-700 to-primary-500"></div>

            <div class="relative z-10 flex flex-col justify-center px-16 text-white">

                <div class="mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mb-6">
                        <svg
                            class="w-8 h-8"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>

                    <h1 class="text-4xl font-bold tracking-tight">
                        Library Management System
                    </h1>

                    <p class="mt-5 text-lg text-blue-100 max-w-lg leading-relaxed">
                        Manage books, members, borrowing and returns
                        from one simple and organized platform.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-4 max-w-lg">

                    <div class="rounded-xl bg-white/10 backdrop-blur-sm p-4">
                        <div class="text-2xl font-bold">Books</div>
                        <div class="text-sm text-blue-100 mt-1">
                            Manage collection
                        </div>
                    </div>

                    <div class="rounded-xl bg-white/10 backdrop-blur-sm p-4">
                        <div class="text-2xl font-bold">Members</div>
                        <div class="text-sm text-blue-100 mt-1">
                            Manage members
                        </div>
                    </div>

                    <div class="rounded-xl bg-white/10 backdrop-blur-sm p-4">
                        <div class="text-2xl font-bold">Loans</div>
                        <div class="text-sm text-blue-100 mt-1">
                            Track borrowing
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right side --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-10">

            <div class="w-full max-w-md">

                {{-- Mobile logo --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex w-14 h-14 rounded-2xl bg-primary-600 text-white items-center justify-center mb-4">
                        <svg
                            class="w-8 h-8"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"
                            />
                        </svg>
                    </div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        Library Management System
                    </h1>
                </div>

                <main>
                    @yield('content')
                </main>

                <p class="text-center text-sm text-slate-500 mt-8">
                    &copy; {{ date('Y') }} Library Management System
                </p>

            </div>
        </div>

    </div>

</body>
</html>
