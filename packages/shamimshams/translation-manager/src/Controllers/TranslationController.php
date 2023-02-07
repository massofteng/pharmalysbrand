<?php

namespace ShamimShams\TranslationManager\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use ShamimShams\TranslationManager\Exports\TranslationExport;

class TranslationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function download()
    {
        return ( new TranslationExport() )->download();
    }
}
