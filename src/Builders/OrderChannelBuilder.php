<?php
namespace Webshipper\Builders;

use Webshipper\Models\OrderChannel;

class OrderChannelBuilder extends Builder
{
    protected $entity = 'order_channels';
    protected $model  = OrderChannel::class;
    protected $type = 'order_channels';

    public function getShippingRates()
    {

        $this->setEntity($this->entity.'/' . $this->{$this->primaryKey} . '/shipping_rates');

        
    }
}