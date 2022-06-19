<?php

namespace Core\Mail\Models;

use Core\Base\Models\Base;
use Illuminate\Support\Facades\Storage;

class Attachment extends Base
{
    protected $appends = [
        'filename',
        'filesize',
        'media_type'
    ];

    /**
     * Returns the filename derived from the filepath.
     *
     * @return string|bool
     */
    public function getFilenameAttribute(): string|bool
    {
        $splitPath = explode('/', $this->filepath);
        return end($splitPath);
    }

    /**
     * Returns the file size in with the appropriate size unit.
     *
     * @return string
     */
    public function getFilesizeAttribute(): string
    {
        $size = Storage::size($this->filepath);
        $sizeUnit = '';
        if ($size >= 524288) {
            $size = number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 512) {
            $size = number_format($size / 1024, 2) . ' KB';
        } else {
            $sizeUnit = ' bytes';
        }

        return $size . $sizeUnit;
    }

    /**
     * Returns the file media type.
     *
     * @return string
     */
    public function getMediaTypeAttribute(): string
    {
        return mime_content_type(Storage::path($this->filepath));
    }

    /**
     * Get the parent attachments model
     */
    public function attachmentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
