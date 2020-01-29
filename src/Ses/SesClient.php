<?php

declare(strict_types=1);

namespace WorkingTitle\Ses;

use WorkingTitle\Aws\AbstractApi;
use WorkingTitle\Aws\ResultPromise;
use WorkingTitle\Aws\Ses\Result\SendEmailResult;

class SesClient extends AbstractApi
{
    /**
     * @return ResultPromise<SendEmailResult>
     */
    public function sendEmail(array $body, array $headers = []): ResultPromise
    {
        $response = $this->getResponse('POST', $body, $headers);

        return new ResultPromise($response, SendEmailResult::class);
    }

    protected function getServiceCode(): string
    {
        return 'ses';
    }
}