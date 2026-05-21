import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { ConfirmDialog } from '../../../greeate/components/confirm-dialog';
import { DataTable, type Column } from '../../../greeate/components/data-table';
import { PageHeader } from '../../../greeate/components/page-header';
import { Input } from '../../../greeate/components/ui/input';
import { useGreeatePermissions } from '../../../greeate/hooks/use-greeate-permissions';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Head, router } from '@inertiajs/react';
import { Search } from 'lucide-react';
import { useState } from 'react';

type Paginator = {
    data: Record<string, unknown>[];
    links: { url: string | null; label: string; active: boolean }[];
    current_page: number;
    last_page: number;
    total: number;
};

type ModuleConfig = {
    permission?: string;
    columns: Column[];
    readonly?: boolean;
};

type Props = {
    module: string;
    moduleConfig: ModuleConfig;
    items: Paginator;
    filters: { search?: string; status?: string };
    title: string;
    basePath: string;
    routePrefix: string;
};

export default function CrudIndex({ module, moduleConfig, items, filters, title, basePath }: Props) {
    const { t } = useGreeateTranslation();
    const { can } = useGreeatePermissions();
    const [search, setSearch] = useState(filters.search ?? '');
    const [deleteId, setDeleteId] = useState<number | null>(null);

    const permissionBase = module.replace('-', '.');
    const canCreate = can(`${permissionBase}.create`) || can('admins.create');
    const canEdit = can(`${permissionBase}.edit`) || can('admins.edit');
    const canDelete = can(`${permissionBase}.delete`) || can('admins.delete');

    const applySearch = () => {
        router.get(basePath, { search: search || undefined }, { preserveState: true });
    };

    const confirmDelete = () => {
        if (deleteId) {
            router.delete(`${basePath}/${deleteId}`, { preserveScroll: true });
            setDeleteId(null);
        }
    };

    return (
        <GreeateAppLayout breadcrumbs={[{ title: t('dashboard', 'Dashboard'), href: `/${basePath.split('/')[1]}` }, { title }]}>
            <Head title={title} />
            <PageHeader
                title={title}
                subtitle={t('manage_records', 'Manage records')}
                createHref={moduleConfig.readonly ? undefined : `${basePath}/create`}
                createLabel={t('create', 'Create')}
            />

            <div className="mb-4 flex gap-2">
                <div className="relative max-w-sm flex-1">
                    <Search className="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input
                        className="pl-9"
                        placeholder={t('search', 'Search...')}
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        onKeyDown={(e) => e.key === 'Enter' && applySearch()}
                    />
                </div>
                <button type="button" onClick={applySearch} className="rounded-md bg-primary px-4 py-2 text-sm text-primary-foreground">
                    {t('search', 'Search')}
                </button>
            </div>

            <DataTable
                columns={moduleConfig?.columns ?? []}
                rows={items.data}
                pagination={items}
                basePath={basePath}
                canEdit={canEdit && !moduleConfig.readonly}
                canDelete={canDelete && !moduleConfig.readonly}
                onDelete={setDeleteId}
            />

            <ConfirmDialog
                open={deleteId !== null}
                title={t('confirm_delete', 'Confirm delete')}
                message={t('delete_warning', 'This action cannot be undone.')}
                onConfirm={confirmDelete}
                onCancel={() => setDeleteId(null)}
            />
        </GreeateAppLayout>
    );
}
