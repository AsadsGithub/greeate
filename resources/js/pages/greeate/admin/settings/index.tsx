import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Form, Head, usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../../../greeate/types';

type Props = {
    group: string;
    settings: Record<string, string>;
};

export default function SettingsIndex({ group, settings }: Props) {
    const { t } = useGreeateTranslation();
    const { greeate } = usePage<GreeateSharedData>().props;
    const prefix = `/${greeate?.adminPrefix ?? 'dashboard'}`;

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('settings', 'Settings') }]}>
            <Head title={t('settings', 'Settings')} />
            <h1 className="mb-6 text-2xl font-bold">{t('settings', 'Settings')} — {group}</h1>
            <div className="max-w-2xl rounded-xl border border-border bg-card p-6">
                <Form action={`${prefix}/settings/${group}`} method="put" className="space-y-4">
                    {({ processing }) => (
                        <>
                            {Object.entries(settings).map(([key, value]) => (
                                <div key={key}>
                                    <Label htmlFor={key}>{key.replace(/_/g, ' ')}</Label>
                                    <Input id={key} name={key} defaultValue={value} className="mt-1" />
                                </div>
                            ))}
                            {Object.keys(settings).length === 0 && (
                                <p className="text-sm text-muted-foreground">No settings in this group yet. Add keys via seeder or database.</p>
                            )}
                            <Button type="submit" disabled={processing}>{t('save', 'Save')}</Button>
                        </>
                    )}
                </Form>
            </div>
        </GreeateAppLayout>
    );
}
