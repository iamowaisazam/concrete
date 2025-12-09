<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTableQuery
{   
    protected $request;
    protected $totalRecords;
    protected $recordsFiltered;
    protected $data;
    protected $length;
    protected $page;
    protected $offset;
    protected $last_page;
    public $query;


    /**
     * Constructor
     */
    public function __construct($query)
    {

         DB::statement("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
        $this->request = request();
        $this->length = (int) $this->request->input('length', 1000);
        $this->page   = (int) $this->request->input('page', 1);
        $this->offset = ($this->page - 1) * $this->length;
        $this->query = $query;

    }


    /**
     * Update current query using a callback
     * Callback receives $query (Eloquent\Builder) and can modify it
     */
    public function query(callable $callback)
    {
        $callback($this->query);

        return $this;
    }


    /**
     * Set custom count callback and update totalRecords immediately
     */
    public function setCount(callable $callback)
    {
        
        // Execute callback on current query and assign to totalRecords
        $this->totalRecords = call_user_func($callback, $this->query);
         return $this;
    }


    /**
     * Get the final formatted response
     */
    public function build()
    {   
        

        $this->data = $this->query
                      ->skip($this->offset)
                      ->take($this->length)
                      ->get();

        $this->last_page = ceil($this->totalRecords / $this->length);
        return $this;

    }

    /**
     * Get the final formatted response
     */
    public function get()
    {   
        $this->data = $this->query->get();
    }

    /**
     * Get the final formatted response
     */
    public function getPaginated(?callable $callback = null)
    {   
        $response = [
            'recordsTotal'    => $this->totalRecords,
            'recordsFiltered' => $this->totalRecords,
            'length'          => $this->length,
            'page'            => $this->page,
            'offset'          => $this->offset,
            'last_page'       => $this->last_page,
            'data'            => $this->data,
        ];


        // If a callback is provided, use it to modify the response
        if ($callback) {
            return $callback($response);
        }

        // Otherwise, return as is
        return $response;

    }

    


}
