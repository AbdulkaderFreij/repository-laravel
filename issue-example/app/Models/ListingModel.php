<?php

namespace App\Models;

use App\Filters\BaseFilter;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;


abstract class ListingModel extends Model {


	/**

	 * Sorts the results according to $sort and direction according to $descending

	 * @param $query

	 * @param $sortBy

	 * @param $descending

	 */

	public function scopeSort($query, $sortBy, $descending){

		$query->when( $sortBy, function ( $query ) use ( $sortBy, $descending ) {

			$order = "asc";

			if ( $descending == "true" ) {

				$order = "desc";

			}

			$query->orderBy( $sortBy, $order );

		}, function($query){

			$query->latest();

		});

    }

    public abstract function scopeFilter($query, BaseFilter $filter = null);


	public abstract function scopeSearch($query, $search);


	public abstract function scopeListing($query);


	// Function to convert class of given object

	function castObjectTo($object, $final_class) {

		return unserialize(sprintf(

			'O:%d:"%s"%s',

			strlen($final_class),

			$final_class,

			strstr(strstr(serialize($object), '"'), ':')

		));

	}


	public function scopeByDate($query, $date, $dateColumn = 'created_at'){

		if( !$date ) {

			return;

		} elseif ( is_array($date) ) {

		    $date = (object) $date;

        } else {

            $date = json_decode($date);

        }

		$type = $date->date;

		$query->when( $type === 'today', function ( $query ) use ( $dateColumn ) {

			$query->whereDate( $dateColumn, Carbon::today() );

		} )->when( $type === 'yesterday', function ( $query ) use ( $dateColumn ) {

			$query->whereDate( $dateColumn, Carbon::yesterday() );

		} )->when( $type === 'single_date', function ( $query ) use ( $dateColumn, $date ) {

			$query->whereDate( $dateColumn, Carbon::parse( $date->value ) );

		} )->when( $type === 'date_range', function ( $query ) use ( $dateColumn, $date ) {

			$query->whereBetween( $dateColumn, [Carbon::parse( $date->value1 ), Carbon::parse( $date->value2 )] );

		} )->when( $type === 'month', function ( $query ) use ( $dateColumn, $date ) {

			$query->where( $dateColumn, '>=', Carbon::today()->subDays( 30 ) );

		} );

	}

}

