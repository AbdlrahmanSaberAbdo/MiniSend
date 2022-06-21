<?php

namespace Core\Mail\Filters;

use Core\Base\Filters\AbstractFilter;

class MailFilter extends AbstractFilter
{
    protected $filters = [
        'mail_search_query' => MailQueryFilter::class
    ];
}
