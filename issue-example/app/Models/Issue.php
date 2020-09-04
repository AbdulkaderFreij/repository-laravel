<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ListingModel;
use App\Filters\BaseFilter;
use App\Models\User;
use App\Models\Store;
use App\Models\Order;
use App\Models\IssueNote;
use App\Managers\FilterManager;

class Issue extends ListingModel
{
    protected $table = 'issue_reports';

    protected $fillable = [
        'status',
    ];

    public function user(){
    return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function reportable()
    {
        return $this->morphTo('reportable');
    }

    public function note(){
        return $this->hasOne(IssueNote::class,'issue_report_id');
    }

    public function scopeFilter($query, BaseFilter $filter = null) {
        $type = $filter->getType();
        $resolved=$filter->getResolved();
        $status=$filter->getStatus();
        $query->where('reportable_type',$type)
            ->when($resolved, function($query) {
                $query->where('status', 2);
            }, function ($query) {
                $query->where('status', '!=', 2);
            })
            ->when($status !== null, function($query) use ($status) {
                $query->where('status', $status);
            });

    }

	public  function scopeSearch($query, $search) {

    }

	public  function scopeListing($query) {
       return $query->with('store','user','note', 'reportable');
    }
}
