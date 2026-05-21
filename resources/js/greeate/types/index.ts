export type BreadcrumbItem = {
    title: string;
    href?: string;
};

export type GreeateSharedData = {
    locale: string;
    rtl: boolean;
    translations: Record<string, string>;
    siteSettings: Record<string, string>;
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
