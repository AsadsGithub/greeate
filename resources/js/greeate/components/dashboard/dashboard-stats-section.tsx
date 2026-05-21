import { Bell, Mail, Shield, Activity } from 'lucide-react';
import { StatsCard } from './stats-card';
import { useGreeateTranslation } from '../../hooks/use-greeate-translation';

type Props = {
    admins: number;
    contacts: number;
    notifications: number;
    systemOnline: string;
};

export function DashboardStatsSection({ admins, contacts, notifications, systemOnline }: Props) {
    const { t } = useGreeateTranslation();

    return (
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <StatsCard title={t('total_admins', 'Total Admins')} value={admins} icon={Shield} />
            <StatsCard title={t('new_contacts', 'New Contacts')} value={contacts} icon={Mail} />
            <StatsCard title={t('notifications', 'Notifications')} value={notifications} icon={Bell} />
            <StatsCard title={t('system_status', 'System Status')} value={systemOnline} icon={Activity} highlight="success" />
        </div>
    );
}
