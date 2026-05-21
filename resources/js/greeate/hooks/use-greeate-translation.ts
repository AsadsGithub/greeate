import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

export function useGreeateTranslation() {
    const { props } = usePage<GreeateSharedData>();
    const translations = props.translations ?? {};
    const locale = props.locale ?? 'en';

    const t = (key: string, fallback?: string) => translations[key] ?? fallback ?? key;

    return { t, locale, rtl: props.rtl ?? false };
}
