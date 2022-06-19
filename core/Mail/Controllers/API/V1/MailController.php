<?php

namespace Core\Mail\Controllers\API\V1;

use Core\Mail\Requests\MailRequest as FormRequest;
use Core\Mail\Models\Mail as Model;
use Core\Mail\Resources\MailResource as Resource;

class MailController extends \Core\Base\Controllers\API\Controller
{
    /**
     * Init.
     * @param FormRequest $request
     * @param Model       $model
     * @param string      $resource
     */
    public function __construct(FormRequest $request, Model $model, $resource = Resource::class)
    {
        parent::__construct($request, $model, $resource);
    }

    public function index()
    {

    }

    public function store()
    {

    }

    public function download()
    {

    }
}
