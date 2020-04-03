<?php
/* Deskall Products Module
* @author: Desall kommunikation  AG, G.Pacilly
* 2019
*/

use SilverStripe\ORM\FieldType\DBCurrency;
use SilverStripe\Core\Config\Config;

Config::modify()->set(DBCurrency::class, 'currency_symbol', 'CHF ');