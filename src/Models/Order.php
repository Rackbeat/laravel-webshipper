<?php

namespace Webshipper\Models;

use Webshipper\Builders\ShipmentBuilder;
use Webshipper\Builders\ShippingRateBuilder;
use Webshipper\Utils\Model;

class Order extends Model
{
	protected $entity     = 'orders';
	protected $primaryKey = 'id';
	protected $type       = 'orders';

	/**
	 * @return mixed
	 * @throws \Webshipper\Exceptions\WebshipperClientException
	 * @throws \Webshipper\Exceptions\WebshipperRequestException
	 */
	public function createShipment()
    {
		$builder = new ShipmentBuilder( $this->request );

		return $builder->create( [
			'relationships' => [
				'order' => [
					'data' => [
						'type' => 'orders',
						'id'   => $this->{$this->primaryKey},
					],
				],
			],
		] );
	}

	/**
	 * @return mixed
	 * @throws \Webshipper\Exceptions\WebshipperClientException
	 * @throws \Webshipper\Exceptions\WebshipperRequestException
	 */
	public function shipments()
    {
		$builder = new ShippingRateBuilder( $this->request );
		$builder->setEntity( $this->entity . '/' . $this->{$this->primaryKey} . '/shipments' );

		return $builder->get();
	}

	/**
	 * Mark order as sent (update status)
	 *
	 * @param string $status
	 *
	 * @return mixed
	 */
	public function markAsSent( $status = 'dispatched' )
    {
		return $this->update( [
			'attributes' => [
				'status' => $status
			]
		] );
	}
}
