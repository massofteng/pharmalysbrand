<?php 
namespace ShamimShams\LWDatatable\Components;

use Illuminate\View\Component;

class Table extends Component
{
    function __construct()
    {

    }

    function render()
    {
        return view('lwdtbl::table');
    }
}