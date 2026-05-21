import { useGreeateTranslation } from '../../greeate/hooks/use-greeate-translation';
import { Head, Link } from '@inertiajs/react';

export default function GreeateComingSoon() {
    const { t } = useGreeateTranslation();

    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-[#A8B5FF] via-[#8B7FD9] to-[#6B46C1] p-6 text-center text-white">
            <Head title={t('coming_soon', 'Coming soon')} />
            <h1 className="text-4xl font-bold">{t('coming_soon', 'Coming soon')}</h1>
            <p className="mt-4 max-w-md text-white/80">We are preparing something great. Check back later.</p>
            <Link href="/" className="mt-8 rounded-lg bg-white/20 px-6 py-2 font-medium backdrop-blur hover:bg-white/30">
                {t('home', 'Home')}
            </Link>
        </div>
    );
}
