import { Link } from '@inertiajs/react';
import { useGreeateRTL } from '../hooks/use-greeate-rtl';
import { cn } from '../lib/utils';

export type Column = {
    key: string;
    label: string;
    type?: 'status' | 'date' | 'roles' | 'boolean';
};

type Paginator<T> = {
    data: T[];
    links: { url: string | null; label: string; active: boolean }[];
    current_page: number;
    last_page: number;
    total: number;
};

type Props<T extends Record<string, unknown>> = {
    columns: Column[];
    rows: T[];
    pagination?: Paginator<T>;
    basePath: string;
    canEdit?: boolean;
    canDelete?: boolean;
    onDelete?: (id: number) => void;
};

function cellValue(row: Record<string, unknown>, col: Column): string {
    const val = row[col.key];
    if (col.type === 'roles' && Array.isArray(val)) {
        return val.map((r: { name?: string }) => r?.name ?? r).join(', ');
    }
    if (col.type === 'boolean') return val ? 'Yes' : 'No';
    if (col.type === 'date' && val) return String(val).slice(0, 10);
    if (col.type === 'status' && val) {
        return String(val);
    }
    return val != null ? String(val) : '—';
}

export function DataTable<T extends Record<string, unknown>>({
    columns,
    rows,
    pagination,
    basePath,
    canEdit = true,
    canDelete = true,
    onDelete,
}: Props<T>) {
    const { isRTL, textAlign } = useGreeateRTL();

    return (
        <div className="data-table overflow-hidden rounded-xl border border-border bg-card shadow-sm">
            <div className="overflow-x-auto">
                <table className="w-full text-sm">
                    <thead className="border-b border-border bg-muted/40">
                        <tr>
                            {columns.map((col) => (
                                <th key={col.key} className={cn('px-4 py-3 font-medium text-muted-foreground', textAlign)}>
                                    {col.label}
                                </th>
                            ))}
                            <th className={cn('px-4 py-3 font-medium text-muted-foreground', isRTL ? 'text-left' : 'text-right')}>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {rows.length === 0 ? (
                            <tr>
                                <td colSpan={columns.length + 1} className="px-4 py-12 text-center text-muted-foreground">
                                    No records found
                                </td>
                            </tr>
                        ) : (
                            rows.map((row) => (
                                <tr key={String(row.id)} className="border-b border-border last:border-0 hover:bg-muted/30">
                                    {columns.map((col) => (
                                        <td key={col.key} className="px-4 py-3">
                                            {col.type === 'status' ? (
                                                <span
                                                    className={cn(
                                                        'inline-flex rounded-full px-2 py-0.5 text-xs font-medium',
                                                        row[col.key] === 'active' || row[col.key] === 'published'
                                                            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'
                                                            : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
                                                    )}
                                                >
                                                    {cellValue(row, col)}
                                                </span>
                                            ) : (
                                                cellValue(row, col)
                                            )}
                                        </td>
                                    ))}
                                    <td className="px-4 py-3 text-right">
                                        <div className="flex items-center justify-end gap-2">
                                            <Link href={`${basePath}/${row.id}`} className="text-primary hover:underline">
                                                View
                                            </Link>
                                            {canEdit && (
                                                <Link href={`${basePath}/${row.id}/edit`} className="text-primary hover:underline">
                                                    Edit
                                                </Link>
                                            )}
                                            {canDelete && onDelete && (
                                                <button
                                                    type="button"
                                                    onClick={() => onDelete(Number(row.id))}
                                                    className="text-destructive hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            )}
                                        </div>
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>
            {pagination && pagination.last_page > 1 && (
                <div className="flex items-center justify-between border-t border-border px-4 py-3">
                    <p className="text-xs text-muted-foreground">
                        Page {pagination.current_page} of {pagination.last_page} ({pagination.total} total)
                    </p>
                    <div className="flex gap-1">
                        {pagination.links.map((link, i) =>
                            link.url ? (
                                <Link
                                    key={i}
                                    href={link.url}
                                    className={cn(
                                        'rounded px-2 py-1 text-xs',
                                        link.active ? 'bg-primary text-primary-foreground' : 'hover:bg-muted',
                                    )}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ) : null,
                        )}
                    </div>
                </div>
            )}
        </div>
    );
}
