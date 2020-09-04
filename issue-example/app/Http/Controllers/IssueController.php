<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Filters\BaseFilter;
use App\Repositories\IssueRepository\IssueRepositoryInterface;
use App\Repositories\IssueNoteRepository\IssueNoteRepositoryInterface;
use App\Http\Requests\Base\ListingRequest;
use App\Http\Requests\Base\StatusRequest;
use App\Http\Requests\Base\NoteRequest;
use App\Managers\FilterManager;
use App\Response;

class IssueController extends Controller
{
    private $issueRepository;

    public function __construct(IssueRepositoryInterface $issueRepository, IssueNoteRepositoryInterface $issueNoteRepository){
        $this->issueRepository = $issueRepository;
        $this->issueNoteRepository = $issueNoteRepository;

    }
    public function pagination(ListingRequest $request){
        $filter = FilterManager::getIssueFilter($request);
        return $this->issueRepository->listing($request, $filter);
    }

    public function updateStatus(StatusRequest $request, $id){
        $didUpdate = $this->issueRepository->update($id, ['status' => $request->status]);
        if( $didUpdate ) {
            return Response::success("Issue updated successfully");
        }
        return Response::error(422, "Could not update the issue");
    }

    public function addNote(NoteRequest $request,$id){
        $didAdd = $this->issueNoteRepository->insert([
            'note' => $request->note,
            'user_type' => 'Admin',
            'user_id'=>1,
            'issue_report_id'=>$id
        ]);
        if( $didAdd ) {
            return Response::success("Note Added successfully");
        }
        return Response::error(422, "Could not Add the note");
    }
}
