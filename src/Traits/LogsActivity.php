<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivity
{
    use SpatieLogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->getFillable())
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName($this->getTable())
            ->setDescriptionForEvent(fn (string $eventName) => $this->getDescriptionForEvent($eventName))
            ->dontLogIfAttributesChangedOnly(['updated_at', 'last_login_at']);
    }

    protected function getDescriptionForEvent(string $eventName): string
    {
        $modelName = Str::title(str_replace('_', ' ', $this->getTable()));
        $causer = Auth::user();
        $causerName = $causer?->name ?? 'System';

        return match ($eventName) {
            'created' => "{$causerName} created {$modelName}",
            'updated' => "{$causerName} updated {$modelName}",
            'deleted' => "{$causerName} deleted {$modelName}",
            default => "{$causerName} {$eventName} {$modelName}",
        };
    }

    public function logAction(string $event, array $properties = []): void
    {
        activity()
            ->performedOn($this)
            ->causedBy(Auth::user())
            ->withProperties($properties)
            ->log($event);
    }
}
