export type BreadcrumbItem = {
    title: string;
    href?: string;
};

export type GreeateActiveLanguage = {
    code: string;
    name: string;
    direction: string;
    is_default: boolean;
};

export type GreeateSettingsGroup = {
    key: string;
    label: string;
};

export type GreeateSharedData = {
    locale: string;
    rtl: boolean;
    translations: Record<string, string>;
    activeLanguages?: GreeateActiveLanguage[];
    settingsGroups?: GreeateSettingsGroup[];
    siteSettings: Record<string, string>;
    unreadNotificationCount?: number;
    flash?: { success?: string; error?: string };
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
            roles: string[];
            permissions: string[];
        } | null;
    };
    greeate: {
        name: string;
        adminPrefix: string;
        registerEnabled: boolean;
    };
};
