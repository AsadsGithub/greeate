import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Form, Head } from '@inertiajs/react';

export default function GreeateResetPassword() {
    const { t } = useGreeateTranslation();

    return (
        <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#A8B5FF] via-[#8B7FD9] to-[#6B46C1] p-6">
            <div className="w-full max-w-md rounded-2xl bg-white/80 p-8 shadow-xl dark:bg-slate-800/80">
                <Head title={t('reset_password', 'Reset password')} />
                <h1 className="mb-6 text-2xl font-bold">{t('reset_password', 'Reset password')}</h1>
                <Form action="/reset-password" method="post" className="space-y-4">
                    <div><Label htmlFor="email">{t('email', 'Email')}</Label><Input id="email" name="email" type="email" required className="mt-1" /></div>
                    <div><Label htmlFor="password">{t('password', 'Password')}</Label><Input id="password" name="password" type="password" required className="mt-1" /></div>
                    <div><Label htmlFor="password_confirmation">{t('confirm_password', 'Confirm')}</Label><Input id="password_confirmation" name="password_confirmation" type="password" required className="mt-1" /></div>
                    <Button type="submit" className="w-full">{t('reset_password', 'Reset password')}</Button>
                </Form>
            </div>
        </div>
    );
}
