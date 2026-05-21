import { Label } from '../ui/label';
import { Input } from '../ui/input';
import { Textarea } from '../ui/textarea';
import { Switch } from '../ui/switch';
import { Select } from '../ui/select';
import { useGreeateRTL } from '../../hooks/use-greeate-rtl';
import { cn } from '../../lib/utils';

export type SettingMeta = {
    id: number;
    key: string;
    value: string;
    type: string;
};

type Props = {
    setting: SettingMeta;
    label: string;
    value: string | boolean;
    onChange: (value: string | boolean) => void;
};

const LAYOUT_OPTIONS = [
    { value: 'sidebar', label: 'Sidebar' },
    { value: 'topbar', label: 'Top bar' },
];

const TIMEZONE_OPTIONS = [
    { value: 'UTC', label: 'UTC' },
    { value: 'Asia/Kuwait', label: 'Asia/Kuwait' },
    { value: 'Asia/Riyadh', label: 'Asia/Riyadh' },
    { value: 'Europe/London', label: 'Europe/London' },
    { value: 'America/New_York', label: 'America/New_York' },
];

function fieldTypeForKey(key: string, type: string): string {
    if (key.includes('email')) return 'email';
    if (key.includes('phone') || key === 'whatsapp') return 'phone';
    if (key.includes('color')) return 'color';
    if (key.includes('url')) return 'url';
    return type === 'boolean' ? 'boolean' : type === 'textarea' ? 'textarea' : 'text';
}

export function SettingField({ setting, label, value, onChange }: Props) {
    const { getFieldDir, getInputTextAlign } = useGreeateRTL();
    const fieldType = fieldTypeForKey(setting.key, setting.type);
    const dir = getFieldDir(fieldType as 'email');
    const align = getInputTextAlign(fieldType as 'email');

    if (setting.type === 'boolean') {
        const checked = value === true || value === 'true';
        return (
            <div className="flex items-center justify-between gap-4 rounded-lg border border-border p-4">
                <div>
                    <Label className="text-sm font-medium">{label}</Label>
                    {setting.description && <p className="mt-0.5 text-xs text-muted-foreground">{setting.description}</p>}
                </div>
                <Switch name={setting.key} checked={checked} onCheckedChange={(v) => onChange(v)} />
            </div>
        );
    }

    if (setting.key === 'layout_type') {
        return (
            <div className="space-y-2">
                <Label htmlFor={setting.key}>{label}</Label>
                <Select
                    id={setting.key}
                    name={setting.key}
                    options={LAYOUT_OPTIONS}
                    value={String(value)}
                    onChange={(e) => onChange(e.target.value)}
                />
            </div>
        );
    }

    if (setting.key === 'timezone') {
        return (
            <div className="space-y-2">
                <Label htmlFor={setting.key}>{label}</Label>
                <Select
                    id={setting.key}
                    name={setting.key}
                    options={TIMEZONE_OPTIONS}
                    value={String(value)}
                    onChange={(e) => onChange(e.target.value)}
                />
            </div>
        );
    }

    if (setting.key === 'default_language') {
        return (
            <div className="space-y-2">
                <Label htmlFor={setting.key}>{label}</Label>
                <Select
                    id={setting.key}
                    name={setting.key}
                    options={[
                        { value: 'en', label: 'English' },
                        { value: 'ar', label: 'العربية' },
                    ]}
                    value={String(value)}
                    onChange={(e) => onChange(e.target.value)}
                />
            </div>
        );
    }

    const isLong = setting.key.includes('description') || setting.key.includes('copyright') || setting.key.includes('keywords');

    return (
        <div className="space-y-2">
            <Label htmlFor={setting.key}>{label}</Label>
            {isLong ? (
                <Textarea
                    id={setting.key}
                    name={setting.key}
                    rows={3}
                    dir={dir}
                    className={cn(align)}
                    value={String(value)}
                    onChange={(e) => onChange(e.target.value)}
                />
            ) : (
                <Input
                    id={setting.key}
                    name={setting.key}
                    type={fieldType === 'color' ? 'color' : fieldType === 'email' ? 'email' : 'text'}
                    dir={dir}
                    className={cn(align, fieldType === 'color' && 'h-10 w-20 cursor-pointer p-1')}
                    value={String(value)}
                    onChange={(e) => onChange(e.target.value)}
                />
            )}
        </div>
    );
}
