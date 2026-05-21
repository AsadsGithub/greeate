import { useState, type ReactNode } from 'react';
import { AppHeader } from '../components/app-header';
import { AppSidebar } from '../components/app-sidebar';
import { cn } from '../lib/utils';
import { type BreadcrumbItem } from '../types';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';

type Props = {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
};

export default function GreeateAppLayout({ children, breadcrumbs }: Props) {
    const { rtl } = useGreeateTranslation();
    const [mobileOpen, setMobileOpen] = useState(false);

    return (
        <div className="min-h-screen bg-background text-foreground" dir={rtl ? 'rtl' : 'ltr'}>
            {mobileOpen && (
                <div className="fixed inset-0 z-30 bg-black/40 lg:hidden" onClick={() => setMobileOpen(false)} />
            )}
            <div className={cn('lg:block', mobileOpen ? 'block' : 'hidden')}>
                <AppSidebar />
            </div>
            <div className={cn('flex min-h-screen flex-col transition-[margin]', rtl ? 'lg:mr-64' : 'lg:ml-64')}>
                <AppHeader breadcrumbs={breadcrumbs} onMenuClick={() => setMobileOpen(true)} />
                <main className="flex-1 p-6">{children}</main>
            </div>
        </div>
    );
}
