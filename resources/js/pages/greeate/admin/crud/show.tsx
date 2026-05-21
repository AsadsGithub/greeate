import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { PageHeader } from '../../../greeate/components/page-header';
import { Button } from '../../../greeate/components/ui/button';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Head, Link } from '@inertiajs/react';

type Props = {
    module: string;
    moduleConfig: { columns: { key: string; label: string }[] };
    item: Record<string, unknown>;
    title: string;
    basePath: string;
};

export default function CrudShow({ moduleConfig, item, title, basePath }: Props) {
    const { t } = useGreeateTranslation();

    return (
        <GreeateAppLayout breadcrumbs={[{ title }, { title: t('view', 'View') }]}>
            <Head title={title} />
            <PageHeader title={title} />
            <div className="max-w-2xl rounded-xl border border-border bg-card p-6 shadow-sm">
                <dl className="space-y-4">
                    {moduleConfig.columns.map((col) => (
                        <div key={col.key} className="flex flex-col gap-1 sm:flex-row sm:gap-4">
                            <dt className="min-w-[120px] text-sm font-medium text-muted-foreground">{col.label}</dt>
                            <dd className="text-sm">{String(item[col.key] ?? '—')}</dd>
                        </div>
                    ))}
                </dl>
                <div className="mt-6 flex gap-2">
                    <Link href={`${basePath}/${item.id}/edit`}>
                        <Button>{t('edit', 'Edit')}</Button>
                    </Link>
                    <Link href={basePath} className="inline-flex h-9 items-center rounded-md border px-4 text-sm">
                        {t('back', 'Back')}
                    </Link>
                </div>
            </div>
        </GreeateAppLayout>
    );
}
