import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Head, Link } from '@inertiajs/react';
import { Button } from '../../../greeate/components/ui/button';

type Paginator<T> = {
    data: T[];
    links: { url: string | null; label: string; active: boolean }[];
};

type Props = {
    title: string;
    resource: string;
    routePrefix: string;
    basePath: string;
    items: Paginator<Record<string, unknown>>;
};

export default function GreeateResourceIndex({ title, resource, basePath, items }: Props) {
    const { t } = useGreeateTranslation();
    const rows = items.data ?? [];
    const keys = rows[0] ? Object.keys(rows[0]).filter((k) => !['password', 'remember_token'].includes(k)).slice(0, 6) : [];

    return (
        <GreeateAppLayout breadcrumbs={[{ title }]}>
            <Head title={title} />
            <div className="mb-6 flex items-center justify-between">
                <h1 className="text-2xl font-bold">{title}</h1>
                <Link href={`${basePath}/create`}>
                    <Button>{t('create', 'Create')}</Button>
                </Link>
            </div>
            <div className="overflow-hidden rounded-xl border border-border bg-card">
                <table className="w-full text-sm">
                    <thead className="border-b border-border bg-muted/50">
                        <tr>
                            {keys.map((k) => (
                                <th key={k} className="px-4 py-3 text-left font-medium capitalize">
                                    {k.replace(/_/g, ' ')}
                                </th>
                            ))}
                            <th className="px-4 py-3 text-right">{t('actions', 'Actions')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {rows.map((row, i) => (
                            <tr key={i} className="border-b border-border last:border-0">
                                {keys.map((k) => (
                                    <td key={k} className="px-4 py-3">
                                        {String(row[k] ?? '')}
                                    </td>
                                ))}
                                <td className="px-4 py-3 text-right">
                                    <Link href={`${basePath}/${row.id}`} className="text-primary hover:underline">
                                        {t('view', 'View')}
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </GreeateAppLayout>
    );
}
