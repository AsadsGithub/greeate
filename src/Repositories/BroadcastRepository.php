<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\BroadcastRepositoryInterface;
use Greeate\Greeate\Models\Broadcast;

class BroadcastRepository extends BaseRepository implements BroadcastRepositoryInterface
{
    protected array $searchableFields = ['target_type', 'status'];

    protected array $filterableFields = ['status', 'target_type'];

    protected array $relationships = ['creator'];

    public function __construct()
    {
        parent::__construct(new Broadcast);
    }
}
