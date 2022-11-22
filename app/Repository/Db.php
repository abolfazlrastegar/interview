<?php
namespace App\Repository;

interface Db
{
    public static function insert($data);

    public static function show($data = null);

}
