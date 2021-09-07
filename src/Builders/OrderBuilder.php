<?php
namespace Webshipper\Builders;

use Webshipper\Models\Order;

class OrderBuilder extends Builder
{
    protected $entity = 'orders';
    protected $model  = Order::class;
    protected $type = 'orders';

    public function markAsSent($id, $status = 'dispatched' )
    {
        return $this->update($id, [
            'attributes' => [
                'status' => $status
            ]
        ]);
    }
}