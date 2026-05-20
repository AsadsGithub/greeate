<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\NotificationRepositoryInterface;
use Greeate\Greeate\Models\GreeateNotification;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    protected array $searchableFields = ['title', 'body', 'type'];

    protected array $filterableFields = ['type', 'channel'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new GreeateNotification());
    }
}
