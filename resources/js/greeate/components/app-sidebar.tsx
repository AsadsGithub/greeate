import { Link, usePage } from '@inertiajs/react';
import {
    Bell,
    FileText,
    HelpCircle,
    Image,
    Languages,
    LayoutGrid,
    Mail,
    Megaphone,
    Settings,
    Shield,
    UserCog,
} from 'lucide-react';
import { useGreeatePermissions } from '../hooks/use-greeate-permissions';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { cn } from '../lib/utils';
import { AppLogo } from './app-logo';

type NavItem = {
    title: string;
    href: string;
    icon: React.ComponentType<{ className?: string }>;
    permission?: string;
};

type NavGroup = { title: string; items: NavItem[] };

export function AppSidebar() {
    const { t } = useGreeateTranslation();
    const { can, isSuperAdmin } = useGreeatePermissions();
    const page = usePage();
    const { greeate } = page.props as { greeate?: { adminPrefix: string } };
    const prefix = `/${greeate?.adminPrefix ?? 'dashboard'}`;
    const currentUrl = page.url;

    const link = (path: string) => `${prefix}${path}`;
    const isActive = (href: string) => currentUrl === href || currentUrl.startsWith(href + '/');

    const show = (permission?: string) => !permission || isSuperAdmin || can(permission);

    const groups: NavGroup[] = [
        {
            title: t('platform', 'Platform'),
            items: [{ title: t('dashboard', 'Dashboard'), href: link(''), icon: LayoutGrid, permission: 'dashboard.view' }],
        },
        {
            title: t('user_management', 'User Management'),
            items: [
                { title: t('admins', 'Admins'), href: link('/admins'), icon: UserCog, permission: 'admins.view' },
                { title: t('roles', 'Roles'), href: link('/roles'), icon: Shield, permission: 'roles.view' },
                { title: t('permissions', 'Permissions'), href: link('/permissions'), icon: Shield, permission: 'permissions.view' },
            ],
        },
        {
            title: t('content', 'Content'),
            items: [
                { title: t('banners', 'Banners'), href: link('/banners'), icon: Image, permission: 'banners.view' },
                { title: t('faqs', 'FAQs'), href: link('/faqs'), icon: HelpCircle, permission: 'faqs.view' },
                { title: t('static_pages', 'Static Pages'), href: link('/static-pages'), icon: FileText, permission: 'static-pages.view' },
                { title: t('languages', 'Languages'), href: link('/languages'), icon: Languages, permission: 'languages.view' },
            ],
        },
        {
            title: t('notifications', 'Notifications'),
            items: [
                { title: t('notifications', 'Notifications'), href: link('/notifications'), icon: Bell, permission: 'notifications.view' },
                { title: t('broadcasts', 'Broadcasts'), href: link('/broadcasts'), icon: Megaphone, permission: 'broadcasts.view' },
                { title: t('contact_messages', 'Messages'), href: link('/contact-messages'), icon: Mail, permission: 'contact-messages.view' },
            ],
        },
        {
            title: t('settings', 'Settings'),
            items: [
                { title: t('settings', 'Settings'), href: link('/settings/general'), icon: Settings, permission: 'site-settings.general.view' },
                { title: t('activity_logs', 'Activity Logs'), href: link('/activity-logs'), icon: FileText, permission: 'activity-logs.view' },
                { title: t('profile', 'Profile'), href: link('/profile'), icon: UserCog },
            ],
        },
    ];

    return (
        <aside className="flex h-full w-64 flex-col border-r border-sidebar-border bg-sidebar text-sidebar-foreground">
            <div className="border-b border-sidebar-border p-4">
                <Link href={link('')}>
                    <AppLogo />
                </Link>
            </div>
            <nav className="flex-1 space-y-6 overflow-y-auto p-3">
                {groups.map((group) => {
                    const items = group.items.filter((i) => show(i.permission));
                    if (!items.length) return null;
                    return (
                        <div key={group.title}>
                            <p className="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-muted-foreground">
                                {group.title}
                            </p>
                            <ul className="space-y-0.5">
                                {items.map((item) => (
                                    <li key={item.href}>
                                        <Link
                                            href={item.href}
                                            className={cn(
                                                'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors',
                                                isActive(item.href)
                                                    ? 'bg-sidebar-primary text-sidebar-primary-foreground shadow-sm'
                                                    : 'text-sidebar-foreground hover:bg-sidebar-accent',
                                            )}
                                        >
                                            <item.icon className="h-4 w-4 shrink-0 opacity-80" />
                                            <span>{item.title}</span>
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    );
                })}
            </nav>
        </aside>
    );
}
