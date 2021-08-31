<?php
namespace Webshipper\Builders;

use Webshipper\Models\Webhook;

class WebhookBuilder extends Builder
{
    protected $entity = 'webhooks';
    protected $model  = Webhook::class;
    protected $type = 'webhooks';
    
    public function delete(int $id)
    {
        return $this->request->handleWithExceptions( function () use ( $id ) {
            $response = $this->request->client->delete( "{$this->entity}/{$id}" );
        } );
    }    
}
