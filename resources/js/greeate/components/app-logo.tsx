import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

export function AppLogo() {
    const { t } = useGreeateTranslation();
    const { siteSettings, greeate } = usePage<GreeateSharedData>().props;
    const name = siteSettings?.site_name || greeate?.name || 'Greeate';
    const logo = siteSettings?.site_logo;

    return (
        <div className="flex items-center gap-2">
            {logo ? (
                <img src={logo} alt={name} className="h-8 w-8 rounded-lg object-contain" />
            ) : (
                <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-[#A8B5FF] to-[#6B46C1] text-sm font-bold text-white">
                    {name.charAt(0).toUpperCase()}
                </div>
            )}
            <span className="truncate font-semibold text-sidebar-foreground">{name}</span>
        </div>
    );
}
