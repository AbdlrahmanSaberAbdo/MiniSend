<?php

namespace Core\Mail\Tests\Feature;

use Core\Base\Tests\TestCase;
use Core\Mail\Models\Attachment;
use Core\Mail\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AttachmentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * the base url
     *
     * @var string
     */
    protected $base_url;

    /**
     * the data that will be sent in the request (create/update)
     *
     * @var array
     */
    protected $data;

    /**
     * the json response
     *
     * @var array
     */
    protected $json;

    /**
     * setting up
     *
     * @throws \ReflectionException
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->base_url     = $this->getApiBaseUrl() . 'attachments/';
        $this->data         = Attachment::factory()->make()->toArray();
        $this->json         = $this->getJsonStructure();
        $this->json['data'] = ['id'];

        foreach ($this->data as $key => $value) {
            $this->json['data'][] = $key;
        }
    }

    /**
     * @test
     */
    public function testDownLoadAttachments()
    {
        Storage::fake();

        $email = Mail::factory()->create();

       $attachment = Attachment::factory()->create([
           'attachmentable_id' => $email->id,
           'attachmentable_type' => 'mail'
       ]);

        $attachment = $email->attachments->first();
        Storage::put($attachment->filepath, $attachment->filename);

        $this->json('GET', $this->base_url.'download?attachment_id='.$attachment->id, [], $this->getHeaders())
            ->assertStatus(Response::HTTP_OK)
            ->assertHeader('content-disposition', 'attachment; filename=' . $attachment->filename);
    }
}
