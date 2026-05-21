import { useEffect, useState, type ReactNode } from 'react';
import { AppHeader } from '../components/app-header';
import { AppSidebar } from '../components/app-sidebar';
import { cn } from '../lib/utils';
import { type BreadcrumbItem } from '../types';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { useGreeateRTLInit } from '../hooks/use-greeate-rtl-init';
import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

type Props = {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
};

export default function GreeateAppLayout({ children, breadcrumbs }: Props) {
    useGreeateRTLInit();
    const { rtl } = useGreeateTranslation();
    const { flash } = usePage<GreeateSharedData>().props;
    const [mobileOpen, setMobileOpen] = useState(false);

    useEffect(() => {
        const onResize = () => {
            if (window.innerWidth >= 1024) {
                setMobileOpen(false);
            }
        };
        window.addEventListener('resize', onResize);
        return () => window.removeEventListener('resize', onResize);
    }, []);

    return (
        <div className="greeate-admin min-h-screen bg-background text-foreground" dir={rtl ? 'rtl' : 'ltr'}>
            {mobileOpen && (
                <div
                    className="fixed inset-0 z-40 bg-black/50 lg:hidden"
                    onClick={() => setMobileOpen(false)}
                    aria-hidden
                />
            )}
            <div
                className={cn(
                    'greeate-sidebar fixed inset-y-0 z-50 w-64 transition-transform duration-200 lg:translate-x-0',
                    rtl ? 'right-0 border-l' : 'left-0 border-r',
                    'border-sidebar-border',
                    mobileOpen ? 'translate-x-0' : rtl ? 'translate-x-full lg:translate-x-0' : '-translate-x-full lg:translate-x-0',
                )}
            >
                <AppSidebar onNavigate={() => setMobileOpen(false)} />
            </div>
            <div className={cn('flex min-h-screen flex-col transition-[margin]', rtl ? 'lg:mr-64' : 'lg:ml-64')}>
                <AppHeader breadcrumbs={breadcrumbs} onMenuClick={() => setMobileOpen(true)} />
                {flash?.success && (
                    <div className="mx-4 mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300 sm:mx-6">
                        {flash.success}
                    </div>
                )}
                {flash?.error && (
                    <div className="mx-4 mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300 sm:mx-6">
                        {flash.error}
                    </div>
                )}
                <main className="flex-1 p-4 sm:p-6">{children}</main>
            </div>
        </div>
    );
}
