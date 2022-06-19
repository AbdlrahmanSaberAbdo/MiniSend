<?php

namespace Core\Mail\Resources;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class AttachmentResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'filepath' => $this->filepath,

            $this->mergeWhen($request->route()->getName() == 'api.v1.attachments.show', [

            ])
        ];
    }
}
