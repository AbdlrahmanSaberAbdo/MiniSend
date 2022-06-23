<?php

namespace Core\Mail\Tests\Feature;

use Core\Base\Tests\TestCase;
use Core\Mail\Jobs\sendEmail;
use Core\Mail\Mail\GenerateEmail;
use Core\Mail\Models\Mail as Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;

class MailTest extends TestCase
{
    use WithFaker, RefreshDatabase;
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
        Mail::fake();
        $this->base_url     = $this->getApiBaseUrl() . 'emails/';
        $this->data         = Model::factory()->make()->toArray();
        $this->json         = $this->getJsonStructure();
        $this->json['data'] = ['id'];

        foreach ($this->data as $key => $value) {
            $this->json['data'][] = $key;
        }
    }

    /**
     * create new entry
     *
     * @return Model
     */
    protected function getNewEntry()
    {
        return Model::factory()->create();
    }

    /**
     * get the id
     *
     * @return int
     */
    protected function getId()
    {
        return $this->getNewEntry()->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testItShouldGetListingOfTheResource()
    {
        $this->getNewEntry();
        $json              = $this->json;
        $json['data']      = [];
        $json['data']['*'] = $this->json['data'];

        $this->json('GET', $this->base_url, [], $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($json);
    }

    /**
     * Store a newly created resource in storage and test if he sent an email when receiving a valid payload
     *
     * @return void
     */
    public function testItShouldStoreNewlyCreatedResource()
    {
        $this->json('POST', $this->base_url, $this->data, $this->getHeaders())
             ->assertStatus(201)
             ->assertJsonStructure($this->json);

        Mail::assertSent(GenerateEmail::class);
    }

    /**
     * @test
     * @param array $payload
     */
    public function testDoesNotSendAnEmailWhenWriteInvalidPayload($payload = []) {
      $this->json('POST', $this->base_url, $payload, $this->getHeaders())->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
      Mail::assertNotSent(GenerateEmail::class);
    }

    /**
     * @test
     */
    public function testItStoreTheEmailAndAttachmentsInTheDatabase()
    {
        $payload = [
            'sender' => $this->faker->email,
            'recipient' => $this->faker->email,
            'subject' => $this->faker->title(),
            'text' => $this->faker->text,
            'status' => 'posted',
            'html' => '<p>test</p>', // TODO: add faker
            'attachments' => [
                UploadedFile::fake()->create('email.pdf', 100)
            ]
        ];

        $this->json('POST', $this->base_url, $payload, $this->getHeaders())->assertStatus(Response::HTTP_CREATED);

        $email = \Core\Mail\Models\Mail::with('attachments')->first();

        $this->assertNotNull($email);
        $this->assertNotNull($email->attachments);

        $this->assertEquals($payload['sender'], $email->sender);
        $this->assertEquals($payload['recipient'], $email->recipient);
        $this->assertEquals($payload['subject'], $email->subject);
        $this->assertEquals($payload['text'], $email->text);
        $this->assertEquals($payload['subject'], $email->subject);
        $this->assertEquals($payload['text'], $email->text);
        $this->assertEquals($payload['html'], $email->html);
        $this->assertEquals($payload['status'], $email->status);
        $this->assertEquals(
            'public/files/' . $payload['attachments'][0]->getClientOriginalName(),
            $email->attachments->first()->filepath
        );
    }

    /**
     * @test
     */
    public function testItEnqueuesAJobToSendAnEmailWhenRecivingAValidPayload()
    {
        Queue::fake();

        $payload = [
            'sender' => $this->faker->email,
            'recipient' => $this->faker->email,
            'subject' => $this->faker->words(3, true),
            'status'    => 'posted',
            'text' => $this->faker->text,
            'html' => $this->faker->randomHtml(1, 1),
            'attachments' => [
                UploadedFile::fake()->create('email.txt', 100)
            ]
        ];

        $this->json('POST', $this->base_url, $payload, $this->getHeaders());

        Queue::assertPushed(SendEmail::class);
    }

    /**
     * @test
     */
    public function testItDoesNotEnqueuesAJobToSendAnEmailWhenRecivingANotValidPayload($payload = [])
    {
        Queue::fake();

        $this->json('POST', $this->base_url, $payload, $this->getHeaders());

        Queue::assertNotPushed(SendEmail::class);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testItShouldGetSpecifiedResource()
    {
        $this->json('GET', $this->base_url . $this->getId(), [], $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($this->json);
    }


    /**
     * update a resource in storage.
     *
     * @return void
     */
    public function testItShouldUpdateSpecifiedResource()
    {
        $this->json('PUT', $this->base_url . $this->getId(), $this->data, $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($this->json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function testItShouldRemoveSpecifiedResource()
    {
        $this->json['data'] = [];
        $this->json('DELETE', $this->base_url . $this->getId(), [], $this->getHeaders())
             ->assertStatus(200)
             ->assertJsonStructure($this->json);
    }
}
