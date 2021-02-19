<?php

declare(strict_types=1);

namespace App\Model;


use Nette\Application\BadRequestException;
use Nette\Utils\DateTime;
use Tracy\Debugger;

class TweetsManager
{
    /** @var string */
    private $wwwDir;

    /** @var TwitterClient */
    private $twitterClient;

    public function __construct(string $wwwDir, TwitterClient $twitterClient)
    {
        $this->wwwDir = $wwwDir;
        $this->twitterClient = $twitterClient;
    }


    /**
     * Vrátí tweety
     */
    public function getTweets(): array
    {
        $searchQuery = $this->getSearchQuery();

        try {
            $tweets = $this->twitterClient->fetchData($searchQuery);
            $tweets = $this->restructureTweets($tweets);
        } catch (BadRequestException $e) {
            Debugger::log($e);
            $tweets = [];
        }

        return $tweets;
    }


    /**
     * Přečte content searchQuery.txt a zformátuje pro twitter API
     */
    private function getSearchQuery(): string
    {
        $searchQuery = file_get_contents($this->wwwDir . '/searchQuery.txt');
        $searchQuery = str_replace(",", " OR ", $searchQuery);

        return $searchQuery;
    }

    /**
     * Upraví strukturu arraye tweetů
     */
    private function restructureTweets(array $tweets): array
    {
        $TWITTER_DOMAIN = "https://twitter.com/";

        $tweetsList = [];
        foreach ($tweets as $tweet) {
            // twitter api vrací GMT timezone
            $createdAt = DateTime::from($tweet->created_at);
            $createdAt->setTimezone(new \DateTimeZone(date_default_timezone_get()));

            $tweetsList[] = [
                'createdAt' => $createdAt,
                'text' => $tweet->full_text,
                'userName' => $tweet->user->name,
                'userScreenName' => $tweet->user->screen_name,
                'favorites' => $tweet->favorite_count,
                'retweets' => $tweet->retweet_count,
                'link' => "{$TWITTER_DOMAIN}{$tweet->user->screen_name}/status/{$tweet->id}",
            ];
        }

        return $tweetsList;
    }
}
