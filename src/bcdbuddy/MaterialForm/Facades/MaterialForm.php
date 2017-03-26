<?php

namespace bcdbuddy\MaterialForm\Facades;

use Illuminate\Support\Facades\Facade;

class MaterialForm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'material-form';
    }
}
