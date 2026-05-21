import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

export function useGreeatePermissions() {
    const { props } = usePage<GreeateSharedData>();
    const user = props.auth?.user;
    const permissions = user?.permissions ?? [];
    const roles = user?.roles ?? [];

    const isSuperAdmin = roles.includes('super-admin') || roles.includes('Super Admin');

    const can = (permission: string) => isSuperAdmin || permissions.includes(permission);

    return { can, isSuperAdmin };
}
