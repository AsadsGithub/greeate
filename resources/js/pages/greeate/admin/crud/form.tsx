import GreeateAppLayout from '../../../greeate/layouts/app-layout';
import { PageHeader } from '../../../greeate/components/page-header';
import { Button } from '../../../greeate/components/ui/button';
import { Input } from '../../../greeate/components/ui/input';
import { Label } from '../../../greeate/components/ui/label';
import { useGreeateTranslation } from '../../../greeate/hooks/use-greeate-translation';
import { Form, Head } from '@inertiajs/react';

type Field = {
    name: string;
    type: string;
    label: string;
    required?: boolean;
    options?: Record<string, string> | string;
};

type Props = {
    action: 'create' | 'edit';
    module: string;
    moduleConfig: { fields?: Field[]; editFields?: Field[] };
    item?: Record<string, unknown>;
    title: string;
    basePath: string;
    formOptions?: { roles?: Record<string, string> };
};

function resolveOptions(field: Field, formOptions?: Props['formOptions']): Record<string, string> {
    if (field.options === 'roles' && formOptions?.roles) return formOptions.roles;
    if (typeof field.options === 'object' && field.options) return field.options;
    return {};
}

export default function CrudForm({ action, moduleConfig, item, title, basePath, formOptions }: Props) {
    const { t } = useGreeateTranslation();
    const fields = action === 'edit' ? (moduleConfig.editFields ?? moduleConfig.fields ?? []) : (moduleConfig.fields ?? []);
    const submitUrl = action === 'create' ? basePath : `${basePath}/${item?.id}`;
    const method = action === 'create' ? 'post' : 'put';

    return (
        <GreeateAppLayout breadcrumbs={[{ title }, { title: action === 'create' ? t('create', 'Create') : t('edit', 'Edit') }]}>
            <Head title={title} />
            <PageHeader title={title} />
            <div className="max-w-2xl rounded-xl border border-border bg-card p-6 shadow-sm">
                <Form action={submitUrl} method={method} className="space-y-5">
                    {({ processing, errors }) => (
                        <>
                            {fields.map((field) => {
                                const opts = resolveOptions(field, formOptions);
                                const defaultVal = item?.[field.name] as string | undefined;
                                return (
                                    <div key={field.name}>
                                        <Label htmlFor={field.name}>{field.label}</Label>
                                        {field.type === 'textarea' ? (
                                            <textarea
                                                id={field.name}
                                                name={field.name}
                                                defaultValue={defaultVal}
                                                required={field.required}
                                                rows={4}
                                                className="mt-1 flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm"
                                            />
                                        ) : field.type === 'select' ? (
                                            <select
                                                id={field.name}
                                                name={field.name}
                                                defaultValue={defaultVal}
                                                className="mt-1 flex h-10 w-full rounded-md border border-input bg-background px-3 text-sm"
                                            >
                                                <option value="">—</option>
                                                {Object.entries(opts).map(([k, v]) => (
                                                    <option key={k} value={k}>
                                                        {v}
                                                    </option>
                                                ))}
                                            </select>
                                        ) : field.type === 'checkbox' ? (
                                            <input
                                                type="checkbox"
                                                id={field.name}
                                                name={field.name}
                                                value="1"
                                                defaultChecked={!!item?.[field.name]}
                                                className="mt-2 rounded"
                                            />
                                        ) : (
                                            <Input
                                                id={field.name}
                                                name={field.name}
                                                type={field.type}
                                                defaultValue={defaultVal}
                                                required={field.required && action === 'create'}
                                                className="mt-1"
                                            />
                                        )}
                                        {errors[field.name] && (
                                            <p className="mt-1 text-sm text-red-600">{errors[field.name]}</p>
                                        )}
                                    </div>
                                );
                            })}
                            <div className="flex gap-2 pt-4">
                                <Button type="submit" disabled={processing}>
                                    {t('save', 'Save')}
                                </Button>
                                <a href={basePath} className="inline-flex h-9 items-center rounded-md border px-4 text-sm">
                                    {t('cancel', 'Cancel')}
                                </a>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </GreeateAppLayout>
    );
}
