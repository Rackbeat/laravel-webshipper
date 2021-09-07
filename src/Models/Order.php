<?php

namespace Webshipper\Models;

use Webshipper\Utils\Model;

class Order extends Model
{
	protected $entity     = 'orders';
	protected $primaryKey = 'id';
	protected $type       = 'orders';
}
