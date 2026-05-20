<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\LanguageRepositoryInterface;
use Greeate\Greeate\Models\Language;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected array $searchableFields = ['name', 'code', 'native_name'];

    protected array $filterableFields = ['is_active', 'is_default'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new Language());
    }
}
