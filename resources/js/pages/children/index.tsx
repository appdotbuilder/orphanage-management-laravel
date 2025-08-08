import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface ChildData {
    id: number;
    name: string;
    nickname: string | null;
    birth_date: string;
    gender: string;
    photo_url: string | null;
    education_level: string | null;
    school_name: string | null;
    status: string;
    age: number;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
    from: number | null;
    to: number | null;
}

interface PageData {
    children: {
        data: ChildData[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    can: {
        create: boolean;
        update: boolean;
        delete: boolean;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Anak Asuh',
        href: '/children',
    },
];

export default function ChildrenIndex() {
    const { children, can } = usePage<PageData>().props;

    const getEducationDisplay = (level: string | null) => {
        if (!level) return 'TK';
        return level.toUpperCase();
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'aktif':
                return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            case 'alumni':
                return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
            case 'pindah':
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Data Anak Asuh" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <span className="mr-2">👥</span>
                            Data Anak Asuh
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Kelola data dan informasi anak asuh di panti
                        </p>
                    </div>
                    {can.create && (
                        <Link
                            href={route('children.create')}
                            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                        >
                            <span className="mr-2">➕</span>
                            Tambah Anak Asuh
                        </Link>
                    )}
                </div>

                {/* Children Grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {children.data.map((child) => (
                        <div
                            key={child.id}
                            className="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow"
                        >
                            <div className="p-6">
                                {/* Photo */}
                                <div className="flex justify-center mb-4">
                                    {child.photo_url ? (
                                        <img
                                            src={child.photo_url}
                                            alt={child.name}
                                            className="h-20 w-20 rounded-full object-cover ring-4 ring-gray-100 dark:ring-gray-700"
                                        />
                                    ) : (
                                        <div className="h-20 w-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                            {child.name.charAt(0).toUpperCase()}
                                        </div>
                                    )}
                                </div>

                                {/* Info */}
                                <div className="text-center">
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                        {child.name}
                                    </h3>
                                    {child.nickname && (
                                        <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                            "{child.nickname}"
                                        </p>
                                    )}
                                    
                                    <div className="space-y-2 mb-4">
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            <span className="font-medium">Umur:</span> {child.age} tahun
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            <span className="font-medium">Jenis Kelamin:</span> {child.gender === 'laki-laki' ? 'Laki-laki' : 'Perempuan'}
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            <span className="font-medium">Pendidikan:</span> {getEducationDisplay(child.education_level)}
                                        </p>
                                        {child.school_name && (
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                <span className="font-medium">Sekolah:</span> {child.school_name}
                                            </p>
                                        )}
                                    </div>

                                    {/* Status Badge */}
                                    <div className="flex justify-center mb-4">
                                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(child.status)}`}>
                                            {child.status.charAt(0).toUpperCase() + child.status.slice(1)}
                                        </span>
                                    </div>

                                    {/* Actions */}
                                    <div className="flex justify-center space-x-2">
                                        <Link
                                            href={route('children.show', child.id)}
                                            className="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-sm rounded-md hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors"
                                        >
                                            👁️ Detail
                                        </Link>
                                        {can.update && (
                                            <Link
                                                href={route('children.edit', child.id)}
                                                className="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                            >
                                                ✏️ Edit
                                            </Link>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Empty State */}
                {children.data.length === 0 && (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">👶</div>
                        <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Belum ada data anak asuh
                        </h3>
                        <p className="text-gray-600 dark:text-gray-400 mb-4">
                            Mulai dengan menambahkan data anak asuh pertama
                        </p>
                        {can.create && (
                            <Link
                                href={route('children.create')}
                                className="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                <span className="mr-2">➕</span>
                                Tambah Anak Asuh
                            </Link>
                        )}
                    </div>
                )}

                {/* Pagination */}
                {children.meta.total > children.meta.per_page && (
                    <div className="flex justify-center mt-6">
                        <nav className="flex space-x-2">
                            {children.links.map((link: PaginationLink, index: number) => (
                                <Link
                                    key={index}
                                    href={link.url || '#'}
                                    className={`px-3 py-2 text-sm rounded-md ${
                                        link.active
                                            ? 'bg-blue-600 text-white'
                                            : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                    } ${
                                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </nav>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}