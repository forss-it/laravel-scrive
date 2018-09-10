<?php
namespace Dialect\Scrive;

use Dialect\Scrive\Model\Document;

class Scrive{

    public static function document($id = null) {
        return new Document($id);
    }
}