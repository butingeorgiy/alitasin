<?php

namespace App\Services\Telegram\Traits;

use Illuminate\Support\Collection;
use Log;
use Telegram\Bot\Objects\Message;

trait TelegramQueueable
{
    /**
     * Collection of Telegram Api responses.
     *
     * @var Collection
     */
    protected Collection $responseBag;

    /**
     * Set Telegram Api response instance.
     *
     * @param Message $response
     */
    protected function setResponse(Message $response): void
    {
        if (!isset($this->responseBag)) {
            $this->responseBag = collect();
        }

        $this->responseBag->push($response);
    }

    /**
     * Get collection of Telegram Api responses.
     *
     * @return Collection
     */
    public function getResponses(): Collection
    {
        return $this->responseBag ?? collect();
    }

    /**
     * Write log with responses.
     */
    public function writeLog(): void
    {
        Log::info('Telegram Api Responses:', ['data' => $this->getResponses()]);
    }
}