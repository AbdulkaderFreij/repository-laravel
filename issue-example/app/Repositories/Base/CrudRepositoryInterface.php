<?php
/**
 * Created by PhpStorm.
 * User: malekhijazi
 * Date: 2/19/19
 * Time: 5:08 PM
 */

namespace App\Repositories\Base;



use App\Filters\BaseFilter;
use Illuminate\Database\Query\Builder;

interface CrudRepositoryInterface {

	function paginate( $model, $search = null, $sort = null, $descending = null, $perPage = 10, BaseFilter $filter = null );

	function all( $model, $search = null, $sort = null, $descending = null, BaseFilter $filter = null, $queryOnly = false );

    function count( $model, $search = null, BaseFilter $filter = null );

	function updateOrCreate( $model, $input );

	function insert( $model, $data );

	function insertMultiple($model, $data);

	function update( $mode, $id, $data );

	function delete( $model, $id );

    function find($model, $id);

    /**
     * Returns all rows for a column in order to export. This will not work unless the model uses the ExportableModel trait.
     *
     * @param $model
     * @param BaseFilter|null $filter
     * @param null $search
     * @param null $sort
     * @param null $descending
     * @return Builder
     */
    function export( $model, BaseFilter $filter = null, $search = null, $sort = null, $descending = null );

}
