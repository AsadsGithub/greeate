<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\DeviceTokenRepositoryInterface;
use Greeate\Greeate\Models\DeviceToken;

class DeviceTokenRepository extends BaseRepository implements DeviceTokenRepositoryInterface
{
    protected array $searchableFields = ['token', 'platform'];

    protected array $filterableFields = ['admin_id', 'platform'];

    protected array $relationships = ['admin'];

    public function __construct()
    {
        parent::__construct(new DeviceToken);
    }
}
