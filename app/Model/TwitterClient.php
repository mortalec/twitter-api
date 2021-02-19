<?php

declare(strict_types=1);

namespace App\Model;


use Nette\Application\BadRequestException;

class TwitterClient
{
    /** @var string */
    private $url;

    /** @var string */
    private $bearerToken;

    const RESULT_TYPE_MIXED = "mixed",
        RESULT_TYPE_RECENT = "recent",
        RESULT_TYPE_POPULAR = "popular";

    public function __construct(array $twitterParams)
    {
        $this->url = $twitterParams["endpoints"]["getTweets"];
        $this->bearerToken = $twitterParams["bearerToken"];
    }


    /**
     * Získá json data z twitter api a konvertuje je na array
     * @throws BadRequestException
     */
    public function fetchData(string $searchQuery) : array
    {
        $curlRequest = $this->createRequest(urlencode($searchQuery));
        $response = curl_exec($curlRequest);
        $error = curl_error($curlRequest);
        if ($error) {
            throw new BadRequestException($error);
        }

        $data = json_decode($response);

        if (json_last_error() == JSON_ERROR_NONE AND !empty($response)) {
            return $data->statuses;
        } else {
            return [];
        }
    }

    /**
     * Připravý curl request
     * @return false|resource
     */
    private function createRequest(string $searchQuery, string $type = self::RESULT_TYPE_MIXED, int $amount = 100)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url . "?q=$searchQuery&result_type=$type&count=$amount&include_entities=true&tweet_mode=extended");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$this->bearerToken}"
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
        return $curl;
    }
}
