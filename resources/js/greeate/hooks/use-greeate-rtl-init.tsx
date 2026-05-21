import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

export function useGreeateRTLInit() {
    const { locale, rtl } = usePage<GreeateSharedData>().props;

    useEffect(() => {
        if (typeof document === 'undefined') {
            return;
        }

        const html = document.documentElement;
        const body = document.body;
        const dir = rtl ? 'rtl' : 'ltr';

        html.setAttribute('dir', dir);
        html.setAttribute('lang', locale ?? 'en');
        body?.classList.toggle('rtl', Boolean(rtl));
        body?.classList.toggle('greeate-rtl', Boolean(rtl));
    }, [rtl, locale]);
}
