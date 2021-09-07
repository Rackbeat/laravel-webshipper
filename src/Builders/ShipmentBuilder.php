<?php
namespace Webshipper\Builders;

use Webshipper\Models\Shipment;

class ShipmentBuilder extends Builder
{
    protected $entity = 'shipments';
    protected $model  = Shipment::class;
    protected $type = 'shipments';

    public function createOrderShipment($orderId)
    {
        return $this->create( [
            'relationships' => [
                'order' => [
                    'data' => [
                        'type' => 'orders',
                        'id'   => $orderId,
                    ],
                ],
            ],
        ] );
    }
}