import { Link, router, usePage } from '@inertiajs/react';
import { ChevronDown, LogOut, Menu, Moon, Sun } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { LanguageSwitcher } from './language-switcher';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { useGreeateRTL } from '../hooks/use-greeate-rtl';
import { type BreadcrumbItem, type GreeateSharedData } from '../types';
import { cn } from '../lib/utils';
import { Button } from './ui/button';

type Props = { breadcrumbs?: BreadcrumbItem[]; onMenuClick?: () => void };

export function AppHeader({ breadcrumbs = [], onMenuClick }: Props) {
    const { t } = useGreeateTranslation();
    const { flexDirection } = useGreeateRTL();
    const { auth, unreadNotificationCount = 0 } = usePage<GreeateSharedData>().props;
    const [dark, setDark] = useState(
        typeof document !== 'undefined' && document.documentElement.classList.contains('dark'),
    );
    const [userOpen, setUserOpen] = useState(false);
    const userRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        const stored = localStorage.getItem('greeate-dark');
        if (stored === 'true') {
            document.documentElement.classList.add('dark');
            setDark(true);
        }
    }, []);

    useEffect(() => {
        const onClick = (e: MouseEvent) => {
            if (userRef.current && !userRef.current.contains(e.target as Node)) {
                setUserOpen(false);
            }
        };
        document.addEventListener('mousedown', onClick);
        return () => document.removeEventListener('mousedown', onClick);
    }, []);

    const toggleDark = () => {
        const next = !dark;
        setDark(next);
        document.documentElement.classList.toggle('dark', next);
        localStorage.setItem('greeate-dark', String(next));
    };

    return (
        <header className="greeate-header sticky top-0 z-30 flex h-14 items-center justify-between gap-2 border-b border-border bg-card/95 px-3 backdrop-blur-md sm:px-4">
            <div className={cn('flex min-w-0 flex-1 items-center gap-2', flexDirection)}>
                <button
                    type="button"
                    className="shrink-0 rounded-md p-2 hover:bg-accent lg:hidden"
                    onClick={onMenuClick}
                    aria-label="Menu"
                >
                    <Menu className="h-5 w-5" />
                </button>
                <nav className="hidden min-w-0 truncate text-sm text-muted-foreground md:flex md:flex-wrap md:gap-2">
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
                <span className="truncate text-sm font-medium md:hidden">
                    {breadcrumbs[breadcrumbs.length - 1]?.title ?? t('dashboard', 'Dashboard')}
                </span>
            </div>

            <div className={cn('flex shrink-0 items-center gap-1 sm:gap-2', flexDirection)}>
                <LanguageSwitcher />
                <Button type="button" variant="ghost" size="sm" onClick={toggleDark} className="px-2">
                    {dark ? <Sun className="h-4 w-4" /> : <Moon className="h-4 w-4" />}
                </Button>
                {unreadNotificationCount > 0 && (
                    <span className="hidden rounded-full bg-primary px-2 py-0.5 text-xs text-primary-foreground sm:inline">
                        {unreadNotificationCount}
                    </span>
                )}
                <div ref={userRef} className="relative">
                    <button
                        type="button"
                        className={cn(
                            'flex items-center gap-1 rounded-md px-2 py-1.5 text-sm hover:bg-accent',
                            flexDirection,
                        )}
                        onClick={() => setUserOpen((v) => !v)}
                    >
                        <span className="hidden max-w-[8rem] truncate sm:inline">{auth.user?.name}</span>
                        <ChevronDown className={cn('h-4 w-4 transition', userOpen && 'rotate-180')} />
                    </button>
                    {userOpen && (
                        <div
                            className={cn(
                                'absolute top-full z-50 mt-1 min-w-[10rem] rounded-md border border-border bg-popover p-1 shadow-lg',
                                'end-0',
                            )}
                        >
                            <button
                                type="button"
                                className="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-accent"
                                onClick={() => router.post('/logout')}
                            >
                                <LogOut className="h-4 w-4" />
                                {t('logout', 'Logout')}
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </header>
    );
}
