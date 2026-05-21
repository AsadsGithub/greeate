import { type LucideIcon } from 'lucide-react';
import { Badge } from '../ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { cn } from '../../lib/utils';
import { useGreeateRTL } from '../../hooks/use-greeate-rtl';

type Props = {
    title: string;
    value: string | number;
    icon: LucideIcon;
    highlight?: 'default' | 'success';
    className?: string;
};

export function StatsCard({ title, value, icon: Icon, highlight = 'default', className }: Props) {
    const { flexDirection } = useGreeateRTL();

    return (
        <Card className={cn('transition-all hover:shadow-md hover:shadow-primary/5', className)}>
            <CardHeader className={cn('flex flex-row items-center justify-between space-y-0 pb-2', flexDirection)}>
                <CardTitle className="text-sm font-medium text-muted-foreground">{title}</CardTitle>
                <div className="rounded-full bg-primary/10 p-2">
                    <Icon className="h-4 w-4 text-primary" />
                </div>
            </CardHeader>
            <CardContent>
                {highlight === 'success' ? (
                    <Badge variant="success" className="text-base font-semibold px-3 py-1">
                        {value}
                    </Badge>
                ) : (
                    <div className="text-2xl font-bold tracking-tight sm:text-3xl">{value}</div>
                )}
            </CardContent>
        </Card>
    );
}
