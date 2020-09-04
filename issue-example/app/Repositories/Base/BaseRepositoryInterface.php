<?php
/**
 * Created by PhpStorm.
 * User: malekhijazi
 * Date: 5/24/19
 * Time: 4:40 PM
 */

namespace App\Repositories\Base;


use App\Http\Requests\Base\AddRequest;
use App\Http\Requests\Base\ListingRequest;
use App\Filters\BaseFilter;

interface BaseRepositoryInterface {

	public function listing( ListingRequest $request, BaseFilter $filter = null );

	public function all( $request, BaseFilter $filter = null, $queryOnly = false );

    public function count($request, BaseFilter $filter = null );

	public function updateOrCreateFromRequest( AddRequest $request );

	public function updateOrCreate( $data );

	public function insert( $data );

	public function update( $id, $data );

	public function delete( $id );

    public function find( $id );

    public function getEditHistoryRepository();

    /**
     * Returns all rows for a column in order to export.
     *
     * @param $request
     * @param BaseFilter|null $filter
     * @return \Illuminate\Database\Query\Builder
     */
    public function export( $request, BaseFilter $filter = null );

}
