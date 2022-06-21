<?php


namespace Core\Mail\Filters;


class MailQueryFilter
{
    public function filter($builder, $value)
    {

        return $builder->where([
            [ 'sender', 'like', isset($data['from']) ? '%' . $data['from'] . '%' : '%' ],
            [ 'recipient', 'like', isset($data['to']) ? '%'. $data['to'] . '%' : '%' ],
            [ 'subject', 'like', isset($data['subject']) ? '%'. $data['subject'] . '%' : '%' ]
        ]);
    }
}
