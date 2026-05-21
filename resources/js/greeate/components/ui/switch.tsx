import { cn } from '../../lib/utils';

type Props = {
    id?: string;
    name?: string;
    checked: boolean;
    onCheckedChange: (checked: boolean) => void;
    disabled?: boolean;
};

export function Switch({ id, name, checked, onCheckedChange, disabled }: Props) {
    return (
        <div className="inline-flex items-center">
            {name && <input type="hidden" name={name} value={checked ? 'true' : 'false'} />}
            <button
                type="button"
                id={id}
                role="switch"
                aria-checked={checked}
                disabled={disabled}
                onClick={() => onCheckedChange(!checked)}
                className={cn(
                    'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors',
                    checked ? 'bg-primary' : 'bg-muted',
                    disabled && 'cursor-not-allowed opacity-50',
                )}
            >
                <span
                    className={cn(
                        'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition',
                        checked ? 'translate-x-5' : 'translate-x-0',
                    )}
                />
            </button>
        </div>
    );
}
