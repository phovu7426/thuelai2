<?php

return [
    /*
     * ---------------------------------------------------------------
     * format
     * ---------------------------------------------------------------
     *
     * the formatting of shopping cart values, cart formats the numbers and returns the values in the specified format.
     *
     * Available formats:
     * 
     * 'array', 'json', 'number', 'decimal', 'numeric'
     */
    'format_numbers' => env('SHOPPING_FORMAT_VALUES', 'array'),

    /*
     * ---------------------------------------------------------------
     * shopping cart session identifier
     * ---------------------------------------------------------------
     *
     * This is the prefix of your shopping cart session key.
     */
    'session_key' => 'cart',

    /*
     * ---------------------------------------------------------------
     * shopping cart database table name
     * ---------------------------------------------------------------
     *
     * This is the name of the database table where cart data will be stored.
     */
    'database' => [
        'table' => 'cart_storages'
    ],

    /*
     * ---------------------------------------------------------------
     * Default tax rate
     * ---------------------------------------------------------------
     *
     * This default tax rate will be used when you make a class implement the
     * Taxable interface and use the HasTax trait.
     */
    'tax' => 0,
]; 