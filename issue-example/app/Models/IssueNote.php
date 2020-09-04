<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Issue;

class IssueNote extends Model
{
    protected $table = 'issue_report_notes';
    protected $fillable = [
        "note", "user_type", "user_id", "issue_report_id"
    ];

    public function issues(){
        return $this->belongsToOne(Issue::class);
    }
}
