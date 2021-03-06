<?php

namespace AsyncAws\S3\Tests\Unit\Result;

use AsyncAws\Core\Response;
use AsyncAws\Core\Test\Http\SimpleMockedResponse;
use AsyncAws\Core\Test\TestCase;
use AsyncAws\S3\Enum\RequestCharged;
use AsyncAws\S3\Result\AbortMultipartUploadOutput;
use Symfony\Component\HttpClient\MockHttpClient;

class AbortMultipartUploadOutputTest extends TestCase
{
    public function testAbortMultipartUploadOutput(): void
    {
        // see https://docs.aws.amazon.com/s3/latest/APIReference/API_AbortMultipartUpload.html
        $response = new SimpleMockedResponse('', ['x-amz-request-charged' => 'requester']);

        $client = new MockHttpClient($response);
        $result = new AbortMultipartUploadOutput(new Response($client->request('POST', 'http://localhost'), $client));

        self::assertSame(RequestCharged::REQUESTER, $result->getRequestCharged());
    }

    public function testAbortMultipartUploadOutputNoCharge(): void
    {
        // see https://docs.aws.amazon.com/s3/latest/APIReference/API_AbortMultipartUpload.html
        $response = new SimpleMockedResponse('', []);

        $client = new MockHttpClient($response);
        $result = new AbortMultipartUploadOutput(new Response($client->request('POST', 'http://localhost'), $client));

        self::assertNull($result->getRequestCharged());
    }
}
