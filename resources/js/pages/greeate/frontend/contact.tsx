import { Button } from '../../greeate/components/ui/button';
import { Input } from '../../greeate/components/ui/input';
import { Label } from '../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../greeate/hooks/use-greeate-translation';
import { Form, Head, Link } from '@inertiajs/react';

export default function GreeateContact() {
    const { t } = useGreeateTranslation();

    return (
        <div className="min-h-screen bg-background">
            <Head title={t('contact', 'Contact')} />
            <header className="border-b p-4">
                <Link href="/" className="text-primary hover:underline">
                    ← {t('home', 'Home')}
                </Link>
            </header>
            <main className="mx-auto max-w-lg p-6">
                <h1 className="mb-6 text-2xl font-bold">{t('contact', 'Contact us')}</h1>
                <Form action="/contact" method="post" className="space-y-4 rounded-xl border border-border bg-card p-6">
                    <div>
                        <Label htmlFor="name">{t('name', 'Name')}</Label>
                        <Input id="name" name="name" required className="mt-1" />
                    </div>
                    <div>
                        <Label htmlFor="email">{t('email', 'Email')}</Label>
                        <Input id="email" name="email" type="email" required className="mt-1" />
                    </div>
                    <div>
                        <Label htmlFor="message">Message</Label>
                        <textarea id="message" name="message" required rows={4} className="mt-1 w-full rounded-md border border-input px-3 py-2 text-sm" />
                    </div>
                    <Button type="submit">Send</Button>
                </Form>
            </main>
        </div>
    );
}
