<?php

namespace App\Service;

class Pagination{

    public static function getPagination($limit, $array, $page){
        $offset = abs($page-1) * $limit; //abs() to avoid negative value
        $pages = ceil(count($array)/$limit); //ceil() round to the integer greater than or equal to the given number
        $pagination = array(
            'pages' => $pages,
            'limit' => $limit,
            'offset' => $offset
        );
        return $pagination;
    }
        
}
