<?php

namespace App\Filters;

class BaseFilter {


    public $orderStatus = null;

    public $storeId = null;

	public $date = null;



	/**

	 * @return null

	 */

	public function getOrderStatus() {

		return $this->orderStatus;

	}

	/**

	 * @param null $orderStatus

	 */

	public function setOrderStatus( $orderStatus ): void {

		$this->orderStatus = $orderStatus;

	}



	/**

	 * @return null

	 */

	public function getStoreId() {

		return $this->storeId;

	}



    /**

     * @param null $storeId

     * @throws \Illuminate\Contracts\Container\BindingResolutionException

     */

	public function setStoreId( $storeId ): void {

	    $this->storeId = $storeId;
    }

	/**

	 * @return null

	 */

	public function getDate() {

		return $this->date;

	}



	/**

	 * @param null $date

	 */

	public function setDate( $date ): void {

		$this->date = $date;

	}


}

