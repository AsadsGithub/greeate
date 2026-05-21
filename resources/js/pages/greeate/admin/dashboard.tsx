import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { DashboardStatsSection } from '../../../greeate/components/dashboard/dashboard-stats-section';
import { ActivityContactsPanel } from '../../../greeate/components/dashboard/activity-contacts-panel';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { useGreeateRTL } from '../../../greeate/hooks/use-greeate-rtl';
import { Head } from '@inertiajs/react';
import { cn } from '../../../greeate/lib/utils';

type Activity = { id: number; description: string; created_at: string };
type Contact = { id: number; name: string; email?: string; created_at: string };

type Props = {
    stats: {
        admins: number;
        contacts: number;
        notifications: number;
        activities: Activity[];
        recent_contacts: Contact[];
    };
};

export default function GreeateDashboard({ stats }: Props) {
    const { t } = useGreeateTranslation();
    const { textAlign, dir } = useGreeateRTL();

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('dashboard', 'Dashboard') }]}>
            <Head title={t('dashboard', 'Dashboard')} />
            <div className={cn('flex flex-1 flex-col gap-6', textAlign)} dir={dir}>
                <header className="space-y-1">
                    <h1 className="text-2xl font-bold tracking-tight sm:text-3xl">{t('dashboard', 'Dashboard')}</h1>
                    <p className="text-sm text-muted-foreground sm:text-base">
                        {t('welcome_subtitle', 'Welcome back! Here is what is happening today.')}
                    </p>
                </header>

                <DashboardStatsSection
                    admins={stats.admins}
                    contacts={stats.contacts}
                    notifications={stats.notifications}
                    systemOnline={t('online', 'Online')}
                />

                <ActivityContactsPanel activities={stats.activities ?? []} contacts={stats.recent_contacts ?? []} />
            </div>
        </GreeateAppLayout>
    );
}
