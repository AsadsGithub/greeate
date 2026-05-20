<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\BannerRepositoryInterface;
use Greeate\Greeate\Models\Banner;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    protected array $searchableFields = ['title', 'subtitle'];

    protected array $filterableFields = ['status'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new Banner());
    }
}
