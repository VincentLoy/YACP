<?php

/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 11/26/18
 * Time: 2:44 PM
 */
namespace YACP;

use YACP\YacpPostType;

include "class.YacpPostType.php";

class YACP
{
    public static function init() {
        new \YACP\YacpPostType();
    }
}