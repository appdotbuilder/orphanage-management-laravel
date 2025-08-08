import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';

interface DashboardData {
    stats: {
        totalChildren: number;
        activeChildren: number;
        totalDonations: number;
        totalDonationAmount: number;
    };
    recentChildren: Array<{
        id: number;
        name: string;
        age: number;
        education_level: string;
        entry_date: string;
    }>;
    recentDonations: Array<{
        id: number;
        user: {
            name: string;
        };
        amount: number;
        type: string;
        donation_date: string;
    }>;
    userRole: string;
    auth: {
        user: {
            name: string;
        };
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    const { stats, recentChildren, recentDonations, userRole, auth } = usePage<DashboardData>().props;

    const formatRupiah = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
                    <h1 className="text-2xl font-bold mb-2">
                        Selamat Datang, {auth.user.name}! 👋
                    </h1>
                    <p className="text-blue-100">
                        {userRole === 'admin' && 'Anda memiliki akses penuh ke sistem manajemen panti asuhan.'}
                        {userRole === 'pengurus' && 'Kelola data anak asuh dan kegiatan panti asuhan.'}
                        {userRole === 'donatur' && 'Lihat perkembangan anak asuh dan buat donasi.'}
                        {userRole === 'anak' && 'Lihat profil dan riwayat donasi untuk Anda.'}
                    </p>
                </div>

                {/* Statistics Cards */}
                <div className="grid auto-rows-min gap-4 md:grid-cols-4">
                    <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Anak Asuh</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.totalChildren}</p>
                            </div>
                            <div className="h-12 w-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <span className="text-xl">👥</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Anak Aktif</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.activeChildren}</p>
                            </div>
                            <div className="h-12 w-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                <span className="text-xl">✅</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Donasi</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.totalDonations}</p>
                            </div>
                            <div className="h-12 w-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                <span className="text-xl">🎁</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Dana Terkumpul</p>
                                <p className="text-xl font-bold text-gray-900 dark:text-white">{formatRupiah(stats.totalDonationAmount)}</p>
                            </div>
                            <div className="h-12 w-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                                <span className="text-xl">💰</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Recent Data */}
                <div className="grid gap-6 md:grid-cols-2">
                    {/* Recent Children */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                        <h2 className="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <span className="mr-2">👶</span>
                            Anak Asuh Terbaru
                        </h2>
                        <div className="space-y-3">
                            {recentChildren.map((child) => (
                                <div key={child.id} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">{child.name}</p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            {child.age} tahun • {child.education_level?.toUpperCase() || 'TK'}
                                        </p>
                                    </div>
                                    <p className="text-xs text-gray-500 dark:text-gray-400">
                                        {formatDate(child.entry_date)}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Recent Donations */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                        <h2 className="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <span className="mr-2">💝</span>
                            Donasi Terbaru
                        </h2>
                        <div className="space-y-3">
                            {recentDonations.map((donation) => (
                                <div key={donation.id} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">{donation.user.name}</p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            {donation.type} • {formatRupiah(donation.amount)}
                                        </p>
                                    </div>
                                    <p className="text-xs text-gray-500 dark:text-gray-400">
                                        {formatDate(donation.donation_date)}
                                    </p>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                    <h2 className="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <span className="mr-2">⚡</span>
                        Aksi Cepat
                    </h2>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        {(userRole === 'admin' || userRole === 'pengurus') && (
                            <a 
                                href="/children/create" 
                                className="flex items-center justify-center p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors"
                            >
                                <span className="mr-2">➕</span>
                                Tambah Anak Asuh
                            </a>
                        )}
                        
                        {userRole === 'donatur' && (
                            <a 
                                href="/donations/create" 
                                className="flex items-center justify-center p-4 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors"
                            >
                                <span className="mr-2">💝</span>
                                Buat Donasi
                            </a>
                        )}
                        
                        <a 
                            href="/children" 
                            className="flex items-center justify-center p-4 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors"
                        >
                            <span className="mr-2">👥</span>
                            Lihat Anak Asuh
                        </a>
                        
                        <a 
                            href="/donations" 
                            className="flex items-center justify-center p-4 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/40 transition-colors"
                        >
                            <span className="mr-2">📊</span>
                            Riwayat Donasi
                        </a>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}