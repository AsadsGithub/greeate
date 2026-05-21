import { router, usePage } from '@inertiajs/react';
import { Check, ChevronDown, Globe } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { cn } from '../lib/utils';
import { type GreeateActiveLanguage, type GreeateSharedData } from '../types';
import { Button } from './ui/button';

export function LanguageSwitcher() {
    const { t, rtl } = useGreeateTranslation();
    const { activeLanguages = [], locale } = usePage<GreeateSharedData>().props;
    const [open, setOpen] = useState(false);
    const ref = useRef<HTMLDivElement>(null);

    const languages: GreeateActiveLanguage[] =
        activeLanguages.length > 0
            ? activeLanguages
            : [
                  { code: 'en', name: 'English', direction: 'ltr', is_default: true },
                  { code: 'ar', name: 'العربية', direction: 'rtl', is_default: false },
              ];

    const current = languages.find((l) => l.code === locale) ?? languages[0];

    useEffect(() => {
        const onClick = (e: MouseEvent) => {
            if (ref.current && !ref.current.contains(e.target as Node)) {
                setOpen(false);
            }
        };
        document.addEventListener('mousedown', onClick);
        return () => document.removeEventListener('mousedown', onClick);
    }, []);

    const switchLanguage = (code: string) => {
        setOpen(false);
        router.post(
            `/language/${code}`,
            {},
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    setTimeout(() => window.location.reload(), 100);
                },
            },
        );
    };

    return (
        <div ref={ref} className="relative">
            <Button
                type="button"
                variant="ghost"
                size="sm"
                className={cn('gap-1.5', rtl && 'flex-row-reverse')}
                onClick={() => setOpen((v) => !v)}
                aria-expanded={open}
                aria-haspopup="listbox"
            >
                <Globe className="h-4 w-4" />
                <span className="hidden max-w-[6rem] truncate sm:inline">{current.name}</span>
                <ChevronDown className={cn('h-3.5 w-3.5 transition', open && 'rotate-180')} />
                <span className="sr-only">{t('switch_language', 'Switch language')}</span>
            </Button>
            {open && (
                <ul
                    role="listbox"
                    className={cn(
                        'absolute top-full z-50 mt-1 min-w-[10rem] rounded-md border border-border bg-popover p-1 shadow-lg',
                        rtl ? 'left-0' : 'right-0',
                    )}
                >
                    {languages.map((lang) => (
                        <li key={lang.code}>
                            <button
                                type="button"
                                role="option"
                                aria-selected={locale === lang.code}
                                className={cn(
                                    'flex w-full cursor-pointer items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-accent',
                                    locale === lang.code && 'bg-accent',
                                    rtl && 'flex-row-reverse text-right',
                                )}
                                onClick={() => switchLanguage(lang.code)}
                            >
                                <span className="flex-1">{lang.name}</span>
                                {locale === lang.code && <Check className="h-4 w-4 text-primary" />}
                            </button>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}
