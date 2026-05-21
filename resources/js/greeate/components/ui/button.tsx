import { cn } from '../../lib/utils';
import { type ButtonHTMLAttributes } from 'react';

type Props = ButtonHTMLAttributes<HTMLButtonElement> & {
    variant?: 'default' | 'outline' | 'ghost';
    size?: 'default' | 'sm' | 'lg';
};

export function Button({ className, variant = 'default', size = 'default', ...props }: Props) {
    return (
        <button
            className={cn(
                'inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors disabled:opacity-50',
                variant === 'default' && 'bg-primary text-primary-foreground hover:bg-primary/90',
                variant === 'outline' && 'border border-input bg-background hover:bg-accent',
                variant === 'ghost' && 'hover:bg-accent',
                size === 'default' && 'h-9 px-4',
                size === 'sm' && 'h-8 px-3 text-xs',
                size === 'lg' && 'h-10 px-6',
                className,
            )}
            {...props}
        />
    );
}
