import { usePage } from '@inertiajs/react';
import { getRTLUtilities } from '../utils/rtl-unified';
import { type GreeateSharedData } from '../types';

export function useGreeateRTL() {
    const { locale, rtl } = usePage<GreeateSharedData>().props;
    return getRTLUtilities(rtl ?? false, locale ?? 'en');
}
