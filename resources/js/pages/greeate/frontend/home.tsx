import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { type GreeateSharedData } from '../../../greeate/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function GreeateHome() {
    const { t } = useGreeateTranslation();
    const { siteSettings, greeate } = usePage<GreeateSharedData>().props;
    const name = siteSettings?.site_name || greeate?.name || 'Greeate';

    return (
        <div className="min-h-screen bg-gradient-to-br from-[#A8B5FF] via-[#8B7FD9] to-[#6B46C1] text-white">
            <Head title={t('home', 'Home')} />
            <header className="flex items-center justify-between p-6">
                <span className="text-xl font-bold">{name}</span>
                <div className="flex gap-4 text-sm">
                    <Link href="/contact" className="hover:underline">
                        {t('contact', 'Contact')}
                    </Link>
                    <Link href="/login" className="rounded-lg bg-white/20 px-4 py-2 font-medium backdrop-blur hover:bg-white/30">
                        {t('log_in', 'Log in')}
                    </Link>
                </div>
            </header>
            <main className="mx-auto max-w-3xl px-6 py-24 text-center">
                <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">{name}</h1>
                <p className="mt-6 text-lg text-white/90">
                    {t('welcome_back', 'Modern admin foundation for your next SaaS project.')}
                </p>
                <div className="mt-10 flex flex-wrap justify-center gap-4">
                    <Link
                        href="/login"
                        className="rounded-xl bg-white px-6 py-3 font-semibold text-[#6B46C1] shadow-lg hover:bg-white/90"
                    >
                        {t('log_in', 'Admin login')}
                    </Link>
                    <Link
                        href="/coming-soon"
                        className="rounded-xl border border-white/40 px-6 py-3 font-semibold backdrop-blur hover:bg-white/10"
                    >
                        {t('coming_soon', 'Coming soon')}
                    </Link>
                </div>
            </main>
        </div>
    );
}
