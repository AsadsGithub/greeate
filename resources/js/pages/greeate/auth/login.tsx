import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { cn } from '../../../greeate/lib/utils';
import { type GreeateSharedData } from '../../../greeate/types';
import { Form, Head, Link, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

type Props = {
    canResetPassword?: boolean;
    status?: string;
};

export default function GreeateLogin({ canResetPassword, status }: Props) {
    const { t, rtl } = useGreeateTranslation();
    const { siteSettings, greeate, flash } = usePage<GreeateSharedData>().props;
    const name = siteSettings?.site_name || greeate?.name || 'Greeate';
    const logo = siteSettings?.site_logo;

    return (
        <div
            className="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-[#A8B5FF] via-[#8B7FD9] to-[#6B46C1] p-6 dark:from-slate-900 dark:via-[#4C1D95] dark:to-[#3B0F6B]"
            dir={rtl ? 'rtl' : 'ltr'}
        >
            <div className={cn('absolute top-6 z-10', rtl ? 'right-6' : 'left-6')}>
                <div className="flex items-center gap-3">
                    {logo ? (
                        <img src={logo} alt={name} className="h-8 w-8 rounded-lg object-contain" />
                    ) : (
                        <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-white/20 text-sm font-bold text-white">
                            {name.charAt(0)}
                        </div>
                    )}
                    <span className="text-xl font-bold text-slate-800 dark:text-slate-100">{name}</span>
                </div>
            </div>

            <div className="w-full max-w-md">
                <div className="mb-8 text-center">
                    <h1 className="text-3xl font-bold text-slate-900 dark:text-slate-100">{t('log_in', 'Log in')}</h1>
                    <p className="mt-2 text-slate-600 dark:text-slate-300">
                        {t('login_subtitle', 'Sign in to access your admin dashboard')}
                    </p>
                </div>

                <div className="rounded-2xl border border-slate-200/50 bg-white/80 p-8 shadow-xl backdrop-blur-sm dark:border-slate-700/50 dark:bg-slate-800/80">
                    <Head title={t('log_in', 'Log in')} />

                    {status && <p className="mb-4 text-sm text-green-600">{status}</p>}
                    {flash?.error && <p className="mb-4 text-sm text-red-600">{flash.error}</p>}

                    <Form action="/login" method="post" className="space-y-5">
                        {({ processing, errors }) => (
                            <>
                                <div>
                                    <Label htmlFor="email">{t('email', 'Email')}</Label>
                                    <Input id="email" name="email" type="email" required autoFocus className="mt-1" />
                                    {errors.email && <p className="mt-1 text-sm text-red-600">{errors.email}</p>}
                                </div>
                                <div>
                                    <Label htmlFor="password">{t('password', 'Password')}</Label>
                                    <Input id="password" name="password" type="password" required className="mt-1" />
                                    {errors.password && <p className="mt-1 text-sm text-red-600">{errors.password}</p>}
                                </div>
                                <div className="flex items-center justify-between">
                                    <label className="flex items-center gap-2 text-sm">
                                        <input type="checkbox" name="remember" className="rounded" />
                                        {t('remember_me', 'Remember me')}
                                    </label>
                                    {canResetPassword && (
                                        <Link href="/forgot-password" className="text-sm font-medium text-primary hover:opacity-80">
                                            {t('forgot_password', 'Forgot password?')}
                                        </Link>
                                    )}
                                </div>
                                <Button type="submit" disabled={processing} className="w-full">
                                    {processing && <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />}
                                    {t('log_in', 'Log in')}
                                </Button>
                            </>
                        )}
                    </Form>

                    {greeate?.registerEnabled && (
                        <p className="mt-6 text-center text-sm text-slate-600">
                            {t('no_account', "Don't have an account?")}{' '}
                            <Link href="/register" className="font-medium text-primary">
                                {t('create_account', 'Create account')}
                            </Link>
                        </p>
                    )}
                </div>
            </div>
        </div>
    );
}
