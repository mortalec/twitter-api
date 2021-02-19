<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\TweetsManager;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    /** @var TweetsManager @inject */
    public $tweetsManager;

    /**
     * Klasický výpis dat
     */
    public function renderDefault()
    {
        $tweets = $this->tweetsManager->getTweets();
        $this->template->tweets = Nette\Utils\ArrayHash::from($tweets);
    }

    /**
     * Odpověď v json
     */
    public function renderApi()
    {
        $tweets = $this->tweetsManager->getTweets();
        $this->sendResponse(new Nette\Application\Responses\JsonResponse($tweets));
    }
}
