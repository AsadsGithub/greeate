import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { Select } from '../../../greeate/components/ui/select';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { useGreeateRTL } from '../../../greeate/hooks/use-greeate-rtl';
import { cn } from '../../../greeate/lib/utils';
import { Form, Head, usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../../../greeate/types';

type Admin = { id: number; name: string; email: string; phone?: string; language?: string; timezone?: string };

type Props = { admin: Admin };

const TIMEZONE_OPTIONS = [
    { value: 'UTC', label: 'UTC' },
    { value: 'Asia/Kuwait', label: 'Asia/Kuwait' },
    { value: 'Asia/Riyadh', label: 'Asia/Riyadh' },
    { value: 'Europe/London', label: 'Europe/London' },
    { value: 'America/New_York', label: 'America/New_York' },
];

export default function ProfileEdit({ admin }: Props) {
    const { t } = useGreeateTranslation();
    const { greeate, activeLanguages = [] } = usePage<GreeateSharedData>().props;
    const { getFieldDir, getInputTextAlign } = useGreeateRTL();
    const prefix = `/${greeate?.adminPrefix ?? 'dashboard'}`;

    const languageOptions =
        activeLanguages.length > 0
            ? activeLanguages.map((l) => ({ value: l.code, label: l.name }))
            : [
                  { value: 'en', label: 'English' },
                  { value: 'ar', label: 'العربية' },
              ];

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('profile', 'Profile') }]}>
            <Head title={t('profile', 'Profile')} />
            <h1 className="mb-6 text-2xl font-bold">{t('profile', 'Profile')}</h1>
            <div className="max-w-xl rounded-xl border border-border bg-card p-4 shadow-sm sm:p-6">
                <Form action={`${prefix}/profile`} method="put" className="space-y-4">
                    {({ processing, errors }) => (
                        <>
                            <div>
                                <Label htmlFor="name">{t('name', 'Name')}</Label>
                                <Input id="name" name="name" defaultValue={admin.name} required className="mt-1" />
                                {errors.name && <p className="text-sm text-red-600">{errors.name}</p>}
                            </div>
                            <div>
                                <Label htmlFor="email">{t('email', 'Email')}</Label>
                                <Input
                                    id="email"
                                    name="email"
                                    type="email"
                                    dir={getFieldDir('email')}
                                    className={cn('mt-1', getInputTextAlign('email'))}
                                    defaultValue={admin.email}
                                    required
                                />
                            </div>
                            <div>
                                <Label htmlFor="phone">{t('phone', 'Phone')}</Label>
                                <Input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    dir={getFieldDir('phone')}
                                    className={cn('mt-1', getInputTextAlign('phone'))}
                                    defaultValue={admin.phone}
                                />
                            </div>
                            <div>
                                <Label htmlFor="language">{t('default_language', 'Language')}</Label>
                                <Select
                                    id="language"
                                    name="language"
                                    className="mt-1"
                                    options={languageOptions}
                                    defaultValue={admin.language ?? 'en'}
                                />
                            </div>
                            <div>
                                <Label htmlFor="timezone">{t('timezone', 'Timezone')}</Label>
                                <Select
                                    id="timezone"
                                    name="timezone"
                                    className="mt-1"
                                    options={TIMEZONE_OPTIONS}
                                    defaultValue={admin.timezone ?? 'UTC'}
                                />
                            </div>
                            <div>
                                <Label htmlFor="password">{t('password', 'Password')}</Label>
                                <Input id="password" name="password" type="password" className="mt-1" />
                            </div>
                            <div>
                                <Label htmlFor="password_confirmation">{t('confirm_password', 'Confirm')}</Label>
                                <Input id="password_confirmation" name="password_confirmation" type="password" className="mt-1" />
                            </div>
                            <Button type="submit" disabled={processing}>
                                {t('save', 'Save')}
                            </Button>
                        </>
                    )}
                </Form>
            </div>
        </GreeateAppLayout>
    );
}
