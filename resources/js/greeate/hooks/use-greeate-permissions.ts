import { usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../types';

export function useGreeatePermissions() {
    const { props } = usePage<GreeateSharedData>();
    const user = props.auth?.user;
    const permissions = user?.permissions ?? [];
    const roles = user?.roles ?? [];

    const can = (permission: string) =>
        roles.includes('super-admin') || permissions.includes(permission);

    return { can, isSuperAdmin: roles.includes('super-admin') };
}
