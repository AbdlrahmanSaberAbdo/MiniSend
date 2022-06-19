<?php

namespace Core\Mail\Controllers\API\V1;

use Core\Mail\Requests\MailRequest as FormRequest;
use Core\Mail\Models\Mail as Model;
use Core\Mail\Resources\MailResource as Resource;
use Core\Mail\Trait\AttachmentTrait;

class MailController extends \Core\Base\Controllers\API\Controller
{
    use AttachmentTrait;
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
        $this->sendResponse(
            new $this->resource($this->model->create($this->request->all())),
            'successfully created.',
            true,
            201
        );

        if($this->request->has('attachments')) {
            $email_attachments = $this->getAttachmentsPaths($this->request->get('attachments'));

            $this->model->attachments()->saveMany($email_attachments);
        }
    }

    public function download()
    {

    }
}
