import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Form, Head, Link } from '@inertiajs/react';

export default function GreeateForgotPassword() {
    const { t } = useGreeateTranslation();

    return (
        <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#A8B5FF] via-[#8B7FD9] to-[#6B46C1] p-6">
            <div className="w-full max-w-md rounded-2xl bg-white/80 p-8 shadow-xl dark:bg-slate-800/80">
                <Head title={t('forgot_password', 'Forgot password')} />
                <h1 className="mb-2 text-2xl font-bold">{t('forgot_password', 'Forgot password?')}</h1>
                <p className="mb-6 text-sm text-muted-foreground">{t('forgot_subtitle', '')}</p>
                <Form action="/forgot-password" method="post" className="space-y-4">
                    <div>
                        <Label htmlFor="email">{t('email', 'Email')}</Label>
                        <Input id="email" name="email" type="email" required className="mt-1" />
                    </div>
                    <Button type="submit" className="w-full">{t('send_reset_link', 'Send reset link')}</Button>
                </Form>
                <p className="mt-4 text-center text-sm">
                    <Link href="/login" className="text-primary">{t('back_to_login', 'Back to login')}</Link>
                </p>
            </div>
        </div>
    );
}
