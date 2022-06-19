<?php

namespace Core\Mail\Trait;

use Core\Mail\Models\Attachment;
use Illuminate\Support\Facades\Storage;

trait AttachmentTrait
{
    public function getAttachmentsPaths(array $attachments): array
    {
        $email_attachments = [];
        foreach ($attachments as $attachment)
        {
            Storage::putFileAs('public/files/', $attachment, $attachment->getClientOriginalName());
            $filepath = 'public/files/' . $attachment->getClientOriginalName();

            $attachmentFilePaths[] = $filepath;
            $email_attachments[] = new Attachment(['filepath' => $filepath]);
        }

        return $email_attachments;
    }
}
