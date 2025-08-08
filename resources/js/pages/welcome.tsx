import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Sistem Manajemen Panti Asuhan">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 text-gray-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 dark:text-gray-100">
                {/* Header */}
                <header className="w-full px-6 py-4">
                    <nav className="mx-auto flex max-w-7xl items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600"></div>
                            <span className="text-xl font-bold">SiPanti</span>
                        </div>
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="text-sm font-medium text-gray-700 transition-colors hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400"
                                    >
                                        Masuk
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        Daftar
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="flex-1">
                    <div className="mx-auto max-w-7xl px-6 py-16 sm:py-24">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold tracking-tight sm:text-6xl">
                                🏠 <span className="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Sistem Manajemen</span>
                                <br />
                                <span className="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Panti Asuhan</span>
                            </h1>
                            <p className="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600 dark:text-gray-300">
                                Platform digital yang memudahkan pengelolaan data anak asuh, donasi, kegiatan, dan administrasi panti asuhan dengan sistem yang terintegrasi dan berbasis peran pengguna.
                            </p>
                            
                            {!auth.user && (
                                <div className="mt-10 flex items-center justify-center gap-x-6">
                                    <Link
                                        href={route('register')}
                                        className="rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                    >
                                        Mulai Sekarang
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="text-sm font-semibold leading-6 text-gray-900 transition-colors hover:text-blue-600 dark:text-gray-100 dark:hover:text-blue-400"
                                    >
                                        Sudah punya akun? <span aria-hidden="true">→</span>
                                    </Link>
                                </div>
                            )}
                        </div>

                        {/* Features Grid */}
                        <div className="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                            <div className="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition-shadow hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
                                <div className="flex items-center space-x-3">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                                        <span className="text-xl">👥</span>
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-semibold text-gray-900 dark:text-gray-100">Manajemen Anak Asuh</h3>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">Data lengkap profil anak</p>
                                    </div>
                                </div>
                            </div>

                            <div className="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition-shadow hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
                                <div className="flex items-center space-x-3">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900">
                                        <span className="text-xl">💰</span>
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-semibold text-gray-900 dark:text-gray-100">Sistem Donasi</h3>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">Kelola donasi & transparansi</p>
                                    </div>
                                </div>
                            </div>

                            <div className="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition-shadow hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
                                <div className="flex items-center space-x-3">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                                        <span className="text-xl">🎯</span>
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-semibold text-gray-900 dark:text-gray-100">Kegiatan & Program</h3>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">Organisasi kegiatan harian</p>
                                    </div>
                                </div>
                            </div>

                            <div className="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition-shadow hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
                                <div className="flex items-center space-x-3">
                                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900">
                                        <span className="text-xl">📊</span>
                                    </div>
                                    <div>
                                        <h3 className="text-sm font-semibold text-gray-900 dark:text-gray-100">Dashboard Analytics</h3>
                                        <p className="text-xs text-gray-600 dark:text-gray-400">Laporan & statistik real-time</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Roles Section */}
                        <div className="mt-20">
                            <h2 className="text-center text-2xl font-bold text-gray-900 dark:text-gray-100">
                                🔐 Akses Berdasarkan Peran
                            </h2>
                            <p className="mx-auto mt-4 max-w-2xl text-center text-gray-600 dark:text-gray-300">
                                Sistem keamanan berbasis peran yang memastikan setiap pengguna hanya dapat mengakses fitur sesuai dengan tanggung jawabnya.
                            </p>
                            
                            <div className="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                                <div className="text-center">
                                    <div className="mx-auto h-16 w-16 rounded-full bg-red-100 flex items-center justify-center dark:bg-red-900">
                                        <span className="text-2xl">👑</span>
                                    </div>
                                    <h3 className="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Admin</h3>
                                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">Akses penuh ke seluruh sistem</p>
                                </div>

                                <div className="text-center">
                                    <div className="mx-auto h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center dark:bg-blue-900">
                                        <span className="text-2xl">👔</span>
                                    </div>
                                    <h3 className="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Pengurus</h3>
                                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">Kelola anak asuh & kegiatan</p>
                                </div>

                                <div className="text-center">
                                    <div className="mx-auto h-16 w-16 rounded-full bg-green-100 flex items-center justify-center dark:bg-green-900">
                                        <span className="text-2xl">🤝</span>
                                    </div>
                                    <h3 className="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Donatur</h3>
                                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">Lihat data & buat donasi</p>
                                </div>

                                <div className="text-center">
                                    <div className="mx-auto h-16 w-16 rounded-full bg-yellow-100 flex items-center justify-center dark:bg-yellow-900">
                                        <span className="text-2xl">👶</span>
                                    </div>
                                    <h3 className="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Anak Asuh</h3>
                                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">Akses profil & riwayat pribadi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                    <div className="mx-auto max-w-7xl px-6 py-8">
                        <div className="text-center">
                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                © 2024 Sistem Manajemen Panti Asuhan. Dibuat dengan ❤️ untuk membantu pengelolaan panti asuhan yang lebih baik.
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}