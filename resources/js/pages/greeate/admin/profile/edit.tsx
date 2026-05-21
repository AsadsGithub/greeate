import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Form, Head, usePage } from '@inertiajs/react';
import { type GreeateSharedData } from '../../../greeate/types';

type Admin = { id: number; name: string; email: string; phone?: string; language?: string; timezone?: string };

type Props = { admin: Admin };

export default function ProfileEdit({ admin }: Props) {
    const { t } = useGreeateTranslation();
    const { greeate } = usePage<GreeateSharedData>().props;
    const prefix = `/${greeate?.adminPrefix ?? 'dashboard'}`;

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('profile', 'Profile') }]}>
            <Head title={t('profile', 'Profile')} />
            <h1 className="mb-6 text-2xl font-bold">{t('profile', 'Profile')}</h1>
            <div className="max-w-xl rounded-xl border border-border bg-card p-6">
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
                                <Input id="email" name="email" type="email" defaultValue={admin.email} required className="mt-1" />
                            </div>
                            <div>
                                <Label htmlFor="phone">{t('phone', 'Phone')}</Label>
                                <Input id="phone" name="phone" defaultValue={admin.phone} className="mt-1" />
                            </div>
                            <div>
                                <Label htmlFor="password">{t('password', 'Password')}</Label>
                                <Input id="password" name="password" type="password" className="mt-1" />
                            </div>
                            <div>
                                <Label htmlFor="password_confirmation">{t('confirm_password', 'Confirm')}</Label>
                                <Input id="password_confirmation" name="password_confirmation" type="password" className="mt-1" />
                            </div>
                            <Button type="submit" disabled={processing}>{t('save', 'Save')}</Button>
                        </>
                    )}
                </Form>
            </div>
        </GreeateAppLayout>
    );
}
