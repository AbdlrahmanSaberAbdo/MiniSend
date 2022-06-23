<?php

namespace Core\Mail\Controllers\API\V1;

use Core\Mail\Models\Attachment;
use Core\Mail\Requests\AttachmentRequest as FormRequest;
use Core\Mail\Models\Attachment as Model;
use Core\Mail\Resources\AttachmentResource as Resource;
use Illuminate\Support\Facades\Storage;

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

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $this->request->validate([
           'attachment_id' => 'required'
        ]);

        $attachment = Attachment::findOrFail($this->request->get('attachment_id'));

        return Storage::download($attachment->filepath);
    }
}
