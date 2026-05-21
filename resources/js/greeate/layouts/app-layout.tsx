import { useEffect, useState, type ReactNode } from 'react';
import { AppHeader } from '../components/app-header';
import { AppSidebar } from '../components/app-sidebar';
import { cn } from '../lib/utils';
import { type BreadcrumbItem } from '../types';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

type Props = {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
};

export default function GreeateAppLayout({ children, breadcrumbs }: Props) {
    const { rtl } = useGreeateTranslation();
    const { flash } = usePage<GreeateSharedData>().props;
    const [mobileOpen, setMobileOpen] = useState(false);

    useEffect(() => {
        if (flash?.success) {
            // eslint-disable-next-line no-alert
            console.info(flash.success);
        }
    }, [flash]);

    return (
        <div className="min-h-screen bg-background text-foreground" dir={rtl ? 'rtl' : 'ltr'}>
            {mobileOpen && (
                <div className="fixed inset-0 z-40 bg-black/50 lg:hidden" onClick={() => setMobileOpen(false)} aria-hidden />
            )}
            <div
                className={cn(
                    'fixed inset-y-0 z-50 transition-transform lg:translate-x-0',
                    rtl ? 'right-0' : 'left-0',
                    mobileOpen ? 'translate-x-0' : rtl ? 'translate-x-full' : '-translate-x-full',
                )}
            >
                <AppSidebar />
            </div>
            <div className={cn('flex min-h-screen flex-col', rtl ? 'lg:mr-64' : 'lg:ml-64')}>
                <AppHeader breadcrumbs={breadcrumbs} onMenuClick={() => setMobileOpen(true)} />
                {flash?.success && (
                    <div className="mx-6 mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-300">
                        {flash.success}
                    </div>
                )}
                {flash?.error && (
                    <div className="mx-6 mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300">
                        {flash.error}
                    </div>
                )}
                <main className="flex-1 p-6">{children}</main>
            </div>
        </div>
    );
}
