import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { Button } from '../../../greeate/components/ui/button';
import { SettingField, type SettingMeta } from '../../../greeate/components/settings/setting-field';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { useGreeateRTL } from '../../../greeate/hooks/use-greeate-rtl';
import { cn } from '../../../greeate/lib/utils';
import { type GreeateSettingsGroup } from '../../../greeate/types';
import { Form, Head, Link, usePage } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import { type GreeateSharedData } from '../../../greeate/types';

type Props = {
    group: string;
    settings: SettingMeta[];
    groups: GreeateSettingsGroup[];
};

export default function SettingsIndex({ group, settings, groups }: Props) {
    const { t } = useGreeateTranslation();
    const { textAlign, dir, flexDirection } = useGreeateRTL();
    const { greeate } = usePage<GreeateSharedData>().props;
    const prefix = `/${greeate?.adminPrefix ?? 'dashboard'}`;

    const initial = useMemo(() => {
        const data: Record<string, string | boolean> = {};
        settings.forEach((s) => {
            data[s.key] = s.type === 'boolean' ? s.value === 'true' : s.value;
        });
        return data;
    }, [settings]);

    const [formData, setFormData] = useState(initial);

    const labelFor = (key: string) => t(key, key.replace(/_/g, ' '));

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('settings', 'Settings') }]}>
            <Head title={t('settings', 'Settings')} />
            <div className={cn('flex flex-col gap-6 lg:flex-row', textAlign)} dir={dir}>
                <aside className="w-full shrink-0 lg:w-56">
                    <p className="mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                        {t('select_group', 'Settings group')}
                    </p>
                    <nav className="flex flex-row flex-wrap gap-1 lg:flex-col">
                        {(groups.length ? groups : [{ key: 'general', label: 'General' }]).map((g) => (
                            <Link
                                key={g.key}
                                href={`${prefix}/settings/${g.key}`}
                                className={cn(
                                    'rounded-lg px-3 py-2 text-sm font-medium transition-colors',
                                    group === g.key
                                        ? 'bg-primary text-primary-foreground'
                                        : 'text-muted-foreground hover:bg-accent hover:text-foreground',
                                )}
                            >
                                {g.label}
                            </Link>
                        ))}
                    </nav>
                </aside>

                <div className="min-w-0 flex-1">
                    <div className={cn('mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between', flexDirection)}>
                        <h1 className="text-2xl font-bold">
                            {t('settings', 'Settings')} — {groups.find((g) => g.key === group)?.label ?? group}
                        </h1>
                    </div>

                    <div className="rounded-xl border border-border bg-card p-4 shadow-sm sm:p-6">
                        <Form
                            action={`${prefix}/settings/${group}`}
                            method="put"
                            className="space-y-5"
                            onSubmit={() => {
                                /* values submitted via native inputs */
                            }}
                        >
                            {({ processing }) => (
                                <>
                                    {settings.length === 0 && (
                                        <p className="text-sm text-muted-foreground">
                                            No settings in this group. Run seeders or add keys in the database.
                                        </p>
                                    )}
                                    {settings.map((setting) => (
                                        <SettingField
                                            key={setting.id}
                                            setting={setting}
                                            label={labelFor(setting.key)}
                                            value={formData[setting.key] ?? setting.value}
                                            onChange={(v) => setFormData((prev) => ({ ...prev, [setting.key]: v }))}
                                        />
                                    ))}
                                    {settings.length > 0 && (
                                        <div className={cn('pt-2', flexDirection, 'flex')}>
                                            <Button type="submit" disabled={processing}>
                                                {t('save_settings', 'Save settings')}
                                            </Button>
                                        </div>
                                    )}
                                </>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </GreeateAppLayout>
    );
}
