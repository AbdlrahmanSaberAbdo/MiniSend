<?php


namespace Core\Mail\Filters;


class MailQueryFilter
{
    public function filter($builder, $value)
    {
        $regex = '/[a-z]*:[^\s]*@[^\s]*|[a-z]*:"(.*?)"/';
        $regexResult = null;
            preg_match_all($regex, $value, $regexResult);

        $data = [];

        // Get only first iteration of regex results
        foreach ($regexResult[0] as $result) {
            $aux = explode(':', $result);
            $data[strtolower($aux[0])] = $aux[1];
        }

        return $builder->where([
            [ 'sender', 'like', isset($data['from']) ? '%' . $data['from'] . '%' : '%' ],
            [ 'recipient', 'like', isset($data['to']) ? '%'. $data['to'] . '%' : '%' ],
            [ 'subject', 'like', isset($data['subject']) ? '%'. $data['subject'] . '%' : '%' ]
        ]);
    }
}
