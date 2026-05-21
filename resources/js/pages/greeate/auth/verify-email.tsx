import { Button } from '../../../greeate/components/ui/button';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Form, Head } from '@inertiajs/react';

export default function GreeateVerifyEmail() {
    const { t } = useGreeateTranslation();

    return (
        <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#A8B5FF] via-[#8B7FD9] to-[#6B46C1] p-6">
            <div className="w-full max-w-md rounded-2xl bg-white/80 p-8 text-center shadow-xl dark:bg-slate-800/80">
                <Head title={t('verify_email', 'Verify email')} />
                <h1 className="mb-2 text-2xl font-bold">{t('verify_email', 'Verify your email')}</h1>
                <p className="mb-6 text-sm text-muted-foreground">{t('verify_subtitle', '')}</p>
                <Form action="/verify-email" method="post">
                    <Button type="submit">{t('resend_verification', 'Resend verification')}</Button>
                </Form>
            </div>
        </div>
    );
}
