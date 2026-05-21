import { cn } from '../../lib/utils';
import { type HTMLAttributes } from 'react';

type Props = HTMLAttributes<HTMLSpanElement> & {
    variant?: 'default' | 'secondary' | 'success';
};

export function Badge({ className, variant = 'default', ...props }: Props) {
    return (
        <span
            className={cn(
                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                variant === 'default' && 'bg-primary/15 text-primary',
                variant === 'secondary' && 'bg-muted text-muted-foreground',
                variant === 'success' && 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400',
                className,
            )}
            {...props}
        />
    );
}
