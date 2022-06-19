<?php

namespace Core\Mail\Controllers\API\V1;

use Core\Mail\Requests\AttachmentRequest as FormRequest;
use Core\Mail\Models\Attachment as Model;
use Core\Mail\Resources\AttachmentResource as Resource;

class AttachmentController extends \Core\Base\Controllers\API\Controller
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
}
