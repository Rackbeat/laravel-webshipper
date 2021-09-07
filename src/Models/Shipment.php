<?php

namespace Webshipper\Models;

use Webshipper\Utils\Model;

class Shipment extends Model
{
    protected $entity     = 'shipments';
    protected $primaryKey = 'id';
    protected $type = 'shipments';
}
