<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\FaqRepositoryInterface;
use Greeate\Greeate\Models\Faq;

class FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    protected array $searchableFields = ['question', 'answer', 'category'];

    protected array $filterableFields = ['status', 'category'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new Faq());
    }
}
