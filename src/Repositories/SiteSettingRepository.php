<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\SiteSettingRepositoryInterface;
use Greeate\Greeate\Models\SiteSetting;

class SiteSettingRepository extends BaseRepository implements SiteSettingRepositoryInterface
{
    protected array $searchableFields = ['key', 'value', 'group'];

    protected array $filterableFields = ['group', 'type'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new SiteSetting());
    }
}
