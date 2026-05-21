import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Head } from '@inertiajs/react';

type Activity = { id: number; description: string; created_at: string };
type Contact = { id: number; name: string; created_at: string };

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

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('dashboard', 'Dashboard') }]}>
            <Head title={t('dashboard', 'Dashboard')} />
            <div className="mb-8">
                <h1 className="text-2xl font-bold">{t('dashboard', 'Dashboard')}</h1>
                <p className="mt-1 text-muted-foreground">{t('welcome_back', 'Welcome back!')}</p>
            </div>

            <div className="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                {[
                    { label: t('total_admins', 'Total Admins'), value: stats.admins },
                    { label: t('new_contacts', 'New Contacts'), value: stats.contacts },
                    { label: t('notifications', 'Notifications'), value: stats.notifications },
                    { label: t('system_status', 'System Status'), value: t('online', 'Online') },
                ].map((card) => (
                    <div key={card.label} className="rounded-xl border border-border bg-card p-5 shadow-sm">
                        <p className="text-sm text-muted-foreground">{card.label}</p>
                        <p className="mt-2 text-3xl font-bold">{card.value}</p>
                    </div>
                ))}
            </div>

            <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div className="rounded-xl border border-border bg-card p-5">
                    <h2 className="mb-4 text-lg font-semibold">{t('recent_activities', 'Recent Activities')}</h2>
                    <div className="space-y-3">
                        {stats.activities?.length ? (
                            stats.activities.map((a) => (
                                <div key={a.id} className="text-sm">
                                    <p>{a.description}</p>
                                    <p className="text-xs text-muted-foreground">{a.created_at}</p>
                                </div>
                            ))
                        ) : (
                            <p className="text-sm text-muted-foreground">{t('no_records', 'No records')}</p>
                        )}
                    </div>
                </div>
                <div className="rounded-xl border border-border bg-card p-5">
                    <h2 className="mb-4 text-lg font-semibold">{t('latest_contacts', 'Latest Contacts')}</h2>
                    {stats.recent_contacts?.length ? (
                        stats.recent_contacts.map((c) => (
                            <div key={c.id} className="flex justify-between border-b border-border py-2 text-sm last:border-0">
                                <span>{c.name}</span>
                                <span className="text-muted-foreground">{c.created_at}</span>
                            </div>
                        ))
                    ) : (
                        <p className="text-sm text-muted-foreground">{t('no_records', 'No records')}</p>
                    )}
                </div>
            </div>
        </GreeateAppLayout>
    );
}
