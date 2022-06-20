<?php

namespace Core\Mail\Controllers\API\V1;

use Core\Mail\Jobs\sendEmail;
use Core\Mail\Requests\MailRequest as FormRequest;
use Core\Mail\Models\Mail as Model;
use Core\Mail\Resources\MailResource as Resource;
use Core\Mail\Trait\AttachmentTrait;
use Illuminate\Http\Response;

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
        $query = $this->model::filter($this->request);

        return  $this->sendResponse($this->resource::collection($query->get()));
    }

    public function store()
    {
        $new_email = $this->model->create($this->request->all());
        $this->sendResponse(
            new $this->resource($new_email),
            'successfully created.',
            true,
            201
        );

        if($this->request->has('attachments')) {
            $email_attachments = $this->getAttachmentsPaths($this->request->file('attachments'), 'mail', $new_email->id);
            $this->saveAttachments($email_attachments);
        }
    }

    public function download()
    {

    }
}
