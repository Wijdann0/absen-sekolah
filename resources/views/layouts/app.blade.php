<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? config('app.name', 'Absensi Sekolah') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gradient-to-b from-indigo-600 via-sky-500 to-cyan-400 text-white shadow-lg flex flex-col">
        <div class="p-4 border-b border-white/20">
            <h1 class="text-xl font-bold tracking-tight">Absensi Sekolah</h1>
            @auth
                <p class="text-xs mt-1 text-indigo-100 flex items-center gap-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-300"></span>
                    Login sebagai:
                    <span class="font-semibold capitalize">{{ auth()->user()->role }}</span>
                </p>
                <p class='text-xs mt-1 teks-white flex item-center'>SMPN 6 Cendrawasih</p>
            @endauth
        </div>

        {{-- Menu --}}
        <nav class="flex-1 p-4 space-y-1 text-sm">
            @auth
                @if(auth()->user()->isAdmin())
                    <p class="text-[11px] uppercase tracking-wide text-indigo-100/80 mb-1">Admin</p>
                    <a href="{{ route('admin.dashboard') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.dashboard')) bg-white/15 @endif">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.teachers.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.teachers.*')) bg-white/15 @endif">
                        Data Guru
                    </a>
                    <a href="{{ route('admin.students.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.students.*')) bg-white/15 @endif">
                        Data Murid
                    </a>
                    <a href="{{ route('admin.classes.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.classes.*')) bg-white/15 @endif">
                        Kelas & Mapping
                    </a>
                    <a href="{{ route('admin.reports.students') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.reports.students')) bg-white/15 @endif">
                        Laporan Absensi Murid
                    </a>
                    <a href="{{ route('admin.reports.teachers') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.reports.teachers')) bg-white/15 @endif">
                        Laporan Absensi Guru
                    </a>
                    <a href="{{ route('admin.settings.attendance.edit') }}"
                        class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('admin.settings.attendance.*')) bg-white/15 @endif">
                        Pengaturan Absensi
                    </a>

                @elseif(auth()->user()->isTeacher())
                    <p class="text-[11px] uppercase tracking-wide text-indigo-100/80 mb-1">Guru</p>
                    <a href="{{ route('teacher.dashboard') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('teacher.dashboard')) bg-white/15 @endif">
                        Dashboard
                    </a>
                    <a href="{{ route('teacher.attendance.students.index') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('teacher.attendance.students.*')) bg-white/15 @endif">
                        Absensi Murid
                    </a>
                    <a href="{{ route('teacher.attendance.me') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('teacher.attendance.me*')) bg-white/15 @endif">
                        Absensi Saya
                    </a>
                @elseif(auth()->user()->isStudent())
                    <p class="text-[11px] uppercase tracking-wide text-indigo-100/80 mb-1">Siswa</p>
                    <a href="{{ route('student.dashboard') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('student.dashboard')) bg-white/15 @endif">
                        Dashboard
                    </a>
                    <a href="{{ route('student.attendance.history') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-white/10 @if(request()->routeIs('student.attendance.history')) bg-white/15 @endif">
                        Riwayat Absensi
                    </a>
                @endif
            @endauth
        </nav>

        {{-- Footer / logout --}}
        @auth
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-medium">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    {{-- Main --}}
    <main class="flex-1 p-6">
        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
