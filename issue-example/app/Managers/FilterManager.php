<?php

namespace App\Managers;

use App\Filters\IssueFilter;

class FilterManager {

    public static function getIssueFilter($request) : IssueFilter {
        $filter = new IssueFilter();
        $filter->setType( $request->input('type', 'Order') );
        $filter->setResolved( boolval($request->input('resolved', false)) );
        $filter->setStatus( $request->input('status'));
        return $filter;
    }

}
