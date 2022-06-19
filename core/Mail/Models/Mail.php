<?php

namespace Core\Mail\Models;

use Core\Base\Models\Base;
use Core\Mail\Filters\MailFilter;
use Illuminate\Database\Eloquent\Builder;

class Mail extends Base
{
    /**
     * Get the attachments.
     */
    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function scopeFilter(Builder $builder, $request): Builder
    {
        return (new MailFilter($request))->filter($builder);
    }
}
