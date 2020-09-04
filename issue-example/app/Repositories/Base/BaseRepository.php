<?php
/**
 * Created by PhpStorm.
 * User: malekhijazi
 * Date: 2/19/19
 * Time: 5:07 PM
 */

namespace App\Repositories\Base;

use App\Http\Requests\Base\AddRequest;
use App\Http\Requests\Base\ListingRequest;
use App\Filters\BaseFilter;
use App\Repositories\EditHistory\EditHistoryRepositoryInterface;
use App\Response;

class BaseRepository implements BaseRepositoryInterface {

	private $crudRepository;

	public $model = null;

	public function __construct( CrudRepository $crudRepository, $model = null ) {
		$this->crudRepository = $crudRepository;
		if( $model !== null ) {
		    $this->model = $model;
        }
	}

	/**
	 * Returns a paginated response for a model and parameters sent into ListingRequest and filters the query based on
	 * BaseFilter passed in and handled inside the model scopeFilter($query, $filter). $filter is a class that extends
	 * BaseFilter
	 *
	 * @param ListingRequest $request
	 * @param BaseFilter|null $filter
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function listing( ListingRequest $request, BaseFilter $filter = null ) {

		$search     = $request->search;
		$sort       = $request->sort;
		$descending = $request->descending;
		$perPage    = $request->per_page;

		$data = $this->crudRepository->paginate( $this->model, $search, $sort, $descending, $perPage, $filter );

		return Response::successWithPaging( $data );
	}

    /**
     * Returns all items for a model and parameters sent into ListingRequest and filters the query based on
     * BaseFilter passed in and handled inside the model scopeFilter($query, $filter). $filter is a class that extends
     * BaseFilter
     *
     * @param $request
     * @param BaseFilter|null $filter
     *
     * @param bool $queryOnly
     * @return \Illuminate\Http\JsonResponse
     */
	public function all($request, BaseFilter $filter = null, $queryOnly = false ) {

		$search     = $request->search;
		$sort       = $request->sort;
		$descending = $request->descending;

		$data = $this->crudRepository->all( $this->model, $search, $sort, $descending, $filter, $queryOnly );

		return $data;
	}

    /**
     * Returns the count for the model by search and filter
     *
     * @param $request
     * @param BaseFilter|null $filter
     * @return mixed
     */
	public function count( $request, BaseFilter $filter = null ) {
	    $search = $request->search;
	    return $this->crudRepository->count( $this->model, $search, $filter);
    }

	public function updateOrCreateFromRequest( AddRequest $request ) {
		return $this->updateOrCreate($request->input() );
	}

	public function updateOrCreate( $data ) {
		return $this->crudRepository->updateOrCreate( $this->model, $data );
	}

	public function insert( $data ) {
		$item = $this->crudRepository->insert( $this->model, $data );

		return $item;
	}

	public function update( $id, $data ) {
		return $this->crudRepository->update( $this->model, $id, $data );
	}

	public function delete( $id ) {
		return $this->crudRepository->delete( $this->model, $id );
	}
	public function forceDelete( $id ) {
		return $this->crudRepository->forceDelete( $this->model, $id );
	}

	public function find( $id ) {
	    return $this->crudRepository->find( $this->model, $id );
    }

    public function getEditHistoryRepository() {
        return app()->make( EditHistoryRepositoryInterface::class );
    }

    /**
     * Returns all rows for a column in order to export.
     *
     * @param $request
     * @param BaseFilter|null $filter
     * @return \Illuminate\Database\Query\Builder
     * @throws \Exception
     */
    public function export( $request, BaseFilter $filter = null ) {
        $search     = $request->search;
        $sort       = $request->sort;
        $descending = $request->descending;

        return $this->crudRepository->export( $this->model, $filter, $search, $sort, $descending );
    }


}
