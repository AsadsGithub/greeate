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
    Users,
} from 'lucide-react';
import { useGreeatePermissions } from '../hooks/use-greeate-permissions';
import { useGreeateTranslation } from '../hooks/use-greeate-translation';
import { AppLogo } from './app-logo';

type NavItem = { title: string; href: string; icon: React.ComponentType<{ className?: string }>; show: boolean };

export function AppSidebar() {
    const { t } = useGreeateTranslation();
    const { can } = useGreeatePermissions();
    const { greeate } = usePage().props as { greeate?: { adminPrefix: string } };
    const prefix = `/${greeate?.adminPrefix ?? 'admin'}`;

    const link = (path: string) => `${prefix}${path}`;

    const groups: { title: string; items: NavItem[] }[] = [
        {
            title: t('platform', 'Platform'),
            items: [
                { title: t('dashboard', 'Dashboard'), href: link(''), icon: LayoutGrid, show: can('dashboard.view') },
            ],
        },
        {
            title: t('user_management', 'User Management'),
            items: [
                { title: t('admins', 'Admins'), href: link('/admins'), icon: UserCog, show: can('admins.view') },
                { title: t('roles', 'Roles'), href: link('/roles'), icon: Shield, show: can('roles.view') },
                { title: t('permissions', 'Permissions'), href: link('/permissions'), icon: Shield, show: can('permissions.view') },
            ],
        },
        {
            title: t('content', 'Content'),
            items: [
                { title: t('banners', 'Banners'), href: link('/banners'), icon: Image, show: can('banners.view') },
                { title: t('faqs', 'FAQs'), href: link('/faqs'), icon: HelpCircle, show: can('faqs.view') },
                { title: t('static_pages', 'Static Pages'), href: link('/static-pages'), icon: FileText, show: can('static-pages.view') },
                { title: t('languages', 'Languages'), href: link('/languages'), icon: Languages, show: can('languages.view') },
            ],
        },
        {
            title: t('notifications', 'Notifications'),
            items: [
                { title: t('notifications', 'Notifications'), href: link('/notifications'), icon: Bell, show: can('notifications.view') },
                { title: t('broadcasts', 'Broadcasts'), href: link('/broadcasts'), icon: Megaphone, show: can('broadcasts.view') },
                { title: t('contact_messages', 'Contact'), href: link('/contact-messages'), icon: Mail, show: can('contact-messages.view') },
            ],
        },
        {
            title: t('settings', 'Settings'),
            items: [
                { title: t('settings', 'Settings'), href: link('/settings/general'), icon: Settings, show: can('site-settings.general.view') },
                { title: t('activity_logs', 'Activity Logs'), href: link('/activity-logs'), icon: FileText, show: can('activity-logs.view') },
                { title: t('profile', 'Profile'), href: link('/profile'), icon: Users, show: true },
            ],
        },
    ];

    return (
        <aside className="fixed inset-y-0 z-40 flex w-64 flex-col border-r border-sidebar-border bg-sidebar text-sidebar-foreground ltr:left-0 rtl:right-0">
            <div className="border-b border-sidebar-border p-4">
                <Link href={link('')}>
                    <AppLogo />
                </Link>
            </div>
            <nav className="flex-1 space-y-6 overflow-y-auto p-3">
                {groups.map((group) => {
                    const items = group.items.filter((i) => i.show);
                    if (!items.length) return null;
                    return (
                        <div key={group.title}>
                            <p className="mb-2 px-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                                {group.title}
                            </p>
                            <ul className="space-y-1">
                                {items.map((item) => (
                                    <li key={item.href}>
                                        <Link
                                            href={item.href}
                                            className="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-sidebar-accent"
                                        >
                                            <item.icon className="h-4 w-4 shrink-0" />
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
