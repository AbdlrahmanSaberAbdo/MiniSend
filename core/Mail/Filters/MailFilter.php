<?php

namespace Core\Mail\Filters;

use Core\Base\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MailFilter extends AbstractFilter
{
    protected $filters = [
        'mail_query' => MailQueryFilter::class
    ];
}
