<?php
namespace ShamimShams\LWDatatable\Components;

use Illuminate\View\Component;

class Th extends Component
{
    public $sortable;

    public $direction;

    public $thClass = '';

    public function __construct( $sortable = null, $direction = null )
    {
        $this->sortable  = $sortable;
        $this->direction = $direction;

        if ( $sortable ) {
            $this->thClass .= "sorting";
        }

        if ( $direction == 'asc' ) {
            $this->thClass .= " sorting_asc";
        }

        if ( $direction == 'desc' ) {
            $this->thClass .= " sorting_desc";
        }

    }

    public function render()
    {
        return view( 'lwdtbl::th' );
    }

}
