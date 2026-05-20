<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\ContactMessageRepositoryInterface;
use Greeate\Greeate\Models\ContactMessage;

class ContactMessageRepository extends BaseRepository implements ContactMessageRepositoryInterface
{
    protected array $searchableFields = ['name', 'email', 'subject', 'message'];

    protected array $filterableFields = ['status'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new ContactMessage());
    }
}
