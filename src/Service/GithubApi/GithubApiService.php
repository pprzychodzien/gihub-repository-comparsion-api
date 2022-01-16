<?php

declare(strict_types=1);

namespace App\Service\GithubApi;

use Symfony\Component\HttpClient\Response\CurlResponse;
use App\Service\AbstractApiService;


class GithubApiService extends AbstractApiService

{   
    /**
    * @var string
    */
    private $repo_url = 'https://api.github.com/repos/';

    /**
    * @var string
    */
    private $search_url = 'https://api.github.com/search/';

    public function getRepo(string $repo): ?array
    {
        $response = $this->makeApiCall('GET', $this->repo_url . $repo);
        return $this->processRequest($repo, $response);
    }

    protected function processRequest(string $case, CurlResponse $response): ?array
    {
        if ($response->getStatusCode() === 200){
            return $response->toArray();
        }else{
            return null;
        }
    }

    public function getLastReleaseDate(string $repo): ?string
    {
        $response = $this->makeApiCall('GET', $this->repo_url . $repo . '/releases/latest');
        $result = $this->processRequest($repo, $response);
        return $result ? $result['published_at'] : null;
    }
    public function getOpenPullRequestsCount(string $repo): ?int
    {
        $response = $this->makeApiCall('GET', $this->search_url . 'issues?q=repo:' . $repo . '%20is:pr%20is:open&per_page=1');
        $result = $this->processRequest($repo, $response);
        return $result ? $result['total_count'] : null;
    }
    public function getClosedPullRequestsCount(string $repo): ?int
    {
        $response = $this->makeApiCall('GET', $this->search_url . 'issues?q=repo:' . $repo . '%20is:pr%20is:closed&per_page=1');
        $result = $this->processRequest($repo, $response);
        return $result ? $result['total_count'] : null;
    }
}