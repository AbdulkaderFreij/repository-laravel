<?php
/**
 * Created by PhpStorm.
 * User: malekhijazi
 * Date: 2/19/19
 * Time: 5:08 PM
 */

namespace App\Repositories\Base;


use App\Filters\BaseFilter;
use App\Models\ListingModel;
use App\Response;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class CrudRepository implements CrudRepositoryInterface {

	/**
	 * Returns a paginated response for the model passed in and with the params passed in. The model must extend
	 * ListingModel for this to work as this method requires the model to have search sort and listing scopes defined or
	 * else it would fail.
	 *
	 * @param $model
	 * @param null $search
	 * @param null $sort
	 * @param null $descending
	 * @param int $perPage
	 * @param BaseFilter $filter
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function paginate( $model, $search = null, $sort = null, $descending = null, $perPage = 10, BaseFilter $filter = null ) {
		if ( ! is_subclass_of( $model, ListingModel::class ) ) {
			Return Response::error( 500, "Model must extend ListingModel to be able to use with CrudRepository->paginate method", "$model should extend ListingModel and implement its methods" );
		}
		$items = $model::listing()->filter( $filter )->sort( $sort, $descending )->search( $search )->paginate( $perPage );

		return $items;
	}

    /**
     * Returns all items for the model passed in and with the params passed in. The model must extend
     * ListingModel for this to work as this method requires the model to have search sort and listing scopes defined or
     * else it would fail.
     *
     * @param $model
     * @param null $search
     * @param null $sort
     * @param null $descending
     * @param BaseFilter|null $filter
     *
     * @param bool $queryOnly
     * @return \Illuminate\Http\JsonResponse
     */
	function all( $model, $search = null, $sort = null, $descending = null, BaseFilter $filter = null, $queryOnly = false ) {
		if ( ! is_subclass_of( $model, ListingModel::class ) ) {
			Return Response::error( 500, "Model must extend ListingModel to be able to use with CrudRepository->paginate method", "$model should extend ListingModel and implement its methods" );
		}
		$items = $model::listing()->filter( $filter )->sort( $sort, $descending )->search( $search );

		return $queryOnly ? $items : $items->get();
	}

    /**
     * Returns the count for the model by search and filter
     *
     * @param $model
     * @param null $search
     * @param BaseFilter|null $filter
     * @return mixed
     */
	function count( $model, $search = null, BaseFilter $filter = null ) {
        return $model::filter( $filter )->search( $search )->count();
    }

	/**
	 * Updates or creates a record for the provided model with the attributes from the request object that are found
	 * in the fillable array of the model provided. If the request has attributes that are not in the fillable array, they
	 * will be ignored.
	 *
	 * @param $model
	 * @param $input array to insert or update
	 *
	 * @return Object; record being created or updated
	 */
	function updateOrCreate( $model, $input ) {
		$model = App::make( $model );

		//remove any additional field that is not in the fillable array inside the model
		$fields = $this->validate( $model, $input );

		if ( array_key_exists( 'id', $input ) ) {
			return $model->updateOrCreate( [ 'id' => $input['id'] ], $fields );
		}

		return $model->updateOrCreate( $fields );
	}


	function insert( $model, $data ) {
		$model = App::make( $model );

		//check if multi dimensional array
		if ( isset( $data[0] ) ) {
			return $this->insertMultiple( $model, $data );
		} else {
			//remove any additional field that is not in the fillable array inside the model
			$data = $this->validate( $model, $data );
			$item = $model->create( $data );
			if ( $item ) {
				return $item;
			} else {
				return null;
			}
		}

	}

	function insertMultiple( $model, $data ) {
		foreach ( $data as $key => $value ) {
			$data[ $key ] = $this->validate( $model, $value );
		}
		$items = $model->insert( $data );
		if ( $items ) {
			return $items;
		} else {
			return null;
		}

	}

	/**
	 * Updates a single record with id and attributes sent in as an array
	 *
	 * @param $model
	 * @param $id
	 * @param $data
	 *
	 * @return
	 */
	function update( $model, $id, $data ) {
		$model = App::make( $model );

		//remove any additional field that is not in the fillable array inside the model
		$data = $this->validate( $model, $data );

		return $model->find( $id )->update( $data );

	}

	/**
	 * Deletes a record for the provided model and id. If the record is not found it throws a 409 error and 500 error
	 * if something else went wrong
	 *
	 * @param $model
	 * @param $id
	 *
	 * @return bool
	 */
	function delete( $model, $id ) {
		$model = App::make( $model );
		$item  = $model->find( $id );
		if ( ! $item ) {
			return false;
		} else if ( $item->delete() ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Force deletes a record for the provided model and id. If the record is not found it throws a 409 error and 500 error
	 * if something else went wrong
	 *
	 * @param $model
	 * @param $id
	 *
	 * @return bool
	 */
	function forceDelete( $model, $id ) {
		$model = App::make( $model );
		$item  = $model->find( $id );
		if ( ! $item ) {
			return false;
		} else if ( $item->forceDelete() ) {
			return true;
		} else {
			return false;
		}
	}

	function find($model, $id) {
	    $model = App::make( $model );
	    return $model->find( $id );
    }

	private function validate( $model, $data ) {
		return Arr::only( $data, $model->getFillable() );
	}

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
    function export( $model, BaseFilter $filter = null, $search = null, $sort = null, $descending = null ) {
        $model = App::make( $model );
        if ( is_subclass_of( $model, ListingModel::class ) ) {
            return $model->listing()->filter($filter)->search( $search )->sort( $sort, $descending );
        } else {
            return $model::query();
        }
    }

}
