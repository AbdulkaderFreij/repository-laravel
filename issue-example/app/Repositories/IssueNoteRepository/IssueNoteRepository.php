<?php

namespace App\Repositories\IssueNoteRepository;

use App\Repositories\Base\BaseRepository;
use App\Models\IssueNote;

class IssueNoteRepository extends BaseRepository implements IssueNoteRepositoryInterface{
    public $model = IssueNote::class;
}
