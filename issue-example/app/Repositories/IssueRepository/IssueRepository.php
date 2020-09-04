<?php

namespace App\Repositories\IssueRepository;

use App\Repositories\Base\BaseRepository;
use App\Models\Issue;

class IssueRepository extends BaseRepository implements IssueRepositoryInterface{
    public $model = Issue::class;
}
