import { Link } from '@inertiajs/react';
import { Plus } from 'lucide-react';
import { Button } from './ui/button';

type Props = {
    title: string;
    subtitle?: string;
    createHref?: string;
    createLabel?: string;
};

export function PageHeader({ title, subtitle, createHref, createLabel = 'Create' }: Props) {
    return (
        <div className="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 className="text-2xl font-bold tracking-tight">{title}</h1>
                {subtitle && <p className="mt-1 text-sm text-muted-foreground">{subtitle}</p>}
            </div>
            {createHref && (
                <Link href={createHref}>
                    <Button>
                        <Plus className="h-4 w-4" />
                        {createLabel}
                    </Button>
                </Link>
            )}
        </div>
    );
}
