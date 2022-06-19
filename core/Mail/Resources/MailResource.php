<?php

namespace Core\Mail\Resources;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class MailResource extends Resource
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
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'text' => $this->text,
            'html' => $this->html,
            'status' => $this->status,

            $this->mergeWhen($request->route()->getName() == 'api.v1.mails.show', [

            ])
        ];
    }
}
