import { Link, router, usePage } from '@inertiajs/react';
import { LogOut, Menu, Moon, Sun } from 'lucide-react';
import { useState } from 'react';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { type BreadcrumbItem, type GreeateSharedData } from '../types';
import { cn } from '../lib/utils';

type Props = { breadcrumbs?: BreadcrumbItem[]; onMenuClick?: () => void };

export function AppHeader({ breadcrumbs = [], onMenuClick }: Props) {
    const { t, rtl } = useGreeateTranslation();
    const { auth } = usePage<GreeateSharedData>().props;
    const [dark, setDark] = useState(document.documentElement.classList.contains('dark'));

    const toggleDark = () => {
        const next = !dark;
        setDark(next);
        document.documentElement.classList.toggle('dark', next);
        localStorage.setItem('greeate-dark', String(next));
    };

    return (
        <header className="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-border bg-card/80 px-4 backdrop-blur-md">
            <div className="flex items-center gap-3">
                <button type="button" className="rounded-md p-2 hover:bg-accent lg:hidden" onClick={onMenuClick}>
                    <Menu className="h-5 w-5" />
                </button>
                <nav className="hidden text-sm text-muted-foreground md:flex md:gap-2">
                    {breadcrumbs.map((crumb, i) => (
                        <span key={i} className="flex items-center gap-2">
                            {i > 0 && <span>/</span>}
                            {crumb.href ? (
                                <Link href={crumb.href} className="hover:text-foreground">
                                    {crumb.title}
                                </Link>
                            ) : (
                                <span className="text-foreground">{crumb.title}</span>
                            )}
                        </span>
                    ))}
                </nav>
            </div>
            <div className={cn('flex items-center gap-2', rtl && 'flex-row-reverse')}>
                <button type="button" onClick={toggleDark} className="rounded-md p-2 hover:bg-accent">
                    {dark ? <Sun className="h-4 w-4" /> : <Moon className="h-4 w-4" />}
                </button>
                <span className="hidden text-sm md:inline">{auth.user?.name}</span>
                <button
                    type="button"
                    className="rounded-md p-2 hover:bg-accent"
                    title={t('logout', 'Logout')}
                    onClick={() => router.post('/logout')}
                >
                    <LogOut className="h-4 w-4" />
                </button>
            </div>
        </header>
    );
}
