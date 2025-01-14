<?php
namespace Webshipper\Builders;

use Webshipper\Models\ShippingRate;

class ShippingRateBuilder extends Builder
{
    protected $entity = 'shipping_rates';
    protected $model  = ShippingRate::class;
    protected $type = 'shipping_rates';

    public function getOrderShipments($orderId)
    {
        $this->setEntity('orders/' . $orderId . '/shipments' );

        return $this->get();
    }

    public function getOrderChannelShippingRates($orderChannelId)
    {
        $this->setEntity('order_channels/' . $orderChannelId . '/shipping_rates');

        return $this->get();
    }
}