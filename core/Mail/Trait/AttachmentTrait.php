<?php

namespace Core\Mail\Trait;

use Core\Mail\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait AttachmentTrait
{
    public function getAttachmentsPaths(array $attachments, string $type, $id): array
    {
        $email_attachments = [];
        foreach ($attachments as $attachment)
        {
            Storage::putFileAs('public/files/', $attachment, $attachment->getClientOriginalName());
            $filepath = 'public/files/' . $attachment->getClientOriginalName();

            switch($type) {
                case 'mail':
                    $attachmentFilePaths[] = $filepath;
                    $email_attachments[] = ['filepath' => $filepath, 'attachmentable_type' => 'mail', 'attachmentable_id' => $id];
            }
        }
        return $email_attachments;
    }

    public function saveAttachments(array $attachments) {
        foreach ($attachments as $attachment) {
            $attachment_obj = new Attachment();
            $attachment_obj->attachmentable_id = $attachment['attachmentable_id'];
            $attachment_obj->attachmentable_type = $attachment['attachmentable_type'];
            $attachment_obj->filepath = $attachment['filepath'];

            $attachment_obj->save();
        }
    }
}
