import { Activity, LayoutGrid, Mail } from 'lucide-react';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { useGreeateTranslation } from '../../hooks/use-greeate-translation';
import { useGreeateRTL } from '../../hooks/use-greeate-rtl';
import { cn } from '../../lib/utils';

type ActivityItem = { id: number; description: string; created_at: string };
type ContactItem = { id: number; name: string; email?: string; created_at: string };

type Props = {
    activities: ActivityItem[];
    contacts: ContactItem[];
};

export function ActivityContactsPanel({ activities, contacts }: Props) {
    const { t } = useGreeateTranslation();
    const { textAlign, flexDirection, isRTL } = useGreeateRTL();

    return (
        <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <Card>
                <CardHeader className={cn('flex flex-row items-center gap-2 pb-4', flexDirection)}>
                    <LayoutGrid className="h-5 w-5 text-primary" />
                    <CardTitle className={textAlign}>{t('recent_activities', 'Recent Activities')}</CardTitle>
                </CardHeader>
                <CardContent className={cn('space-y-3', textAlign)}>
                    {activities.length ? (
                        activities.map((a) => (
                            <div
                                key={a.id}
                                className={cn(
                                    'rounded-lg border border-border p-3 text-sm transition-colors hover:bg-muted/30',
                                    flexDirection,
                                    'flex items-start justify-between gap-3',
                                )}
                            >
                                <p className="min-w-0 flex-1 leading-relaxed">{a.description}</p>
                                <time className="shrink-0 text-xs text-muted-foreground whitespace-nowrap">{a.created_at}</time>
                            </div>
                        ))
                    ) : (
                        <div className="py-8 text-center text-muted-foreground">
                            <Activity className="mx-auto mb-2 h-10 w-10 opacity-30" />
                            <p>{t('no_records_found', 'No records found.')}</p>
                        </div>
                    )}
                </CardContent>
            </Card>

            <Card>
                <CardHeader className={cn('flex flex-row items-center gap-2 pb-4', flexDirection)}>
                    <Mail className="h-5 w-5 text-primary" />
                    <CardTitle className={textAlign}>{t('latest_contacts', 'Latest Contacts')}</CardTitle>
                </CardHeader>
                <CardContent className={cn('space-y-3', textAlign)}>
                    {contacts.length ? (
                        contacts.map((c) => (
                            <div
                                key={c.id}
                                className={cn(
                                    'flex items-center justify-between gap-3 rounded-lg border border-border p-3 text-sm',
                                    isRTL && 'flex-row-reverse',
                                )}
                            >
                                <div className="min-w-0">
                                    <p className="font-medium truncate">{c.name}</p>
                                    {c.email && <p className="text-xs text-muted-foreground truncate">{c.email}</p>}
                                </div>
                                <time className="shrink-0 text-xs text-muted-foreground">{c.created_at}</time>
                            </div>
                        ))
                    ) : (
                        <div className="py-8 text-center text-muted-foreground">
                            <Mail className="mx-auto mb-2 h-10 w-10 opacity-30" />
                            <p>{t('no_records_found', 'No records found.')}</p>
                        </div>
                    )}
                </CardContent>
            </Card>
        </div>
    );
}
