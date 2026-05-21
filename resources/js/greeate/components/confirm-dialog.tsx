import { Button } from './ui/button';

type Props = {
    open: boolean;
    title: string;
    message: string;
    onConfirm: () => void;
    onCancel: () => void;
};

export function ConfirmDialog({ open, title, message, onConfirm, onCancel }: Props) {
    if (!open) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div className="w-full max-w-md rounded-xl border border-border bg-card p-6 shadow-xl">
                <h3 className="text-lg font-semibold">{title}</h3>
                <p className="mt-2 text-sm text-muted-foreground">{message}</p>
                <div className="mt-6 flex justify-end gap-2">
                    <Button variant="outline" type="button" onClick={onCancel}>
                        Cancel
                    </Button>
                    <Button type="button" onClick={onConfirm} className="bg-destructive text-white hover:bg-destructive/90">
                        Delete
                    </Button>
                </div>
            </div>
        </div>
    );
}
