<?php

namespace App\Traits;

trait Sortable {

    public function scopeOfSort($query, $sort)
    {
        $q = '';
        foreach ($sort as $column => $direction) {
            $q .= "lower(\"{$column}\"::text) $direction";
            if($sort->keys()->last() != $column) {
                $q .= ',';
            }
//            $query->orderBy($column, $direction);
        }
        $query->orderByRaw($q);
    }

}
