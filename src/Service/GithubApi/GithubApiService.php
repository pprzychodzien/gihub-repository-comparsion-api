<?php

declare(strict_types=1);

namespace App\Service\GithubApi;

use Symfony\Component\HttpClient\Response\CurlResponse;
use App\Service\AbstractApiService;

/**
 * Service for retrieving data form GitHub Api
 *
 * @author  Paweł Przychodzień
 */

class GithubApiService extends AbstractApiService

{   
    /**
     * Repo enpoint URL
     * 
     * @var string
    */
    private $repo_url = 'https://api.github.com/repos/';

    /**
     * Search endpoint URL
     * 
     * @var string
    */
    private $search_url = 'https://api.github.com/search/';

    /**
     * Method for retrieving repositories data
     * 
     * @param string $case repository name   
     * @return array with repository info or null
    */

    public function getRepo(string $case): ?array
    {
        $response = $this->makeApiCall('GET', $this->repo_url . $case);
        return $this->processResponse($case, $response);
    }

    /**
     * Method for processing the response
     * 
     * @param string $case repository name   
     * @param CurlResponse $response api response  
     * @return array with repository info as array or null
    */

    protected function processResponse(string $case, CurlResponse $response): ?array
    {
        if ($response->getStatusCode() === 200){
            return $response->toArray();
        }else{
            return null;
        }
    }

    /**
     * Method for retrieving repositories last release date data
     * 
     * @param string $case repository name   
     * @return string with repository last release date info or null
    */

    public function getLastReleaseDate(string $case): ?string
    {
        $response = $this->makeApiCall('GET', $this->repo_url . $case. '/releases/latest');
        $result = $this->processResponse($case, $response);
        return $result ? $result['published_at'] : null;
    }

    /**
     * Method for retrieving repositories open pull requests count data
     * 
     * @param string $case repository name   
     * @return int with repository open pull requests count or null
    */

    public function getOpenPullRequestsCount(string $case): ?int
    {
        $response = $this->makeApiCall('GET', $this->search_url . 'issues?q=repo:' . $case. '%20is:pr%20is:open&per_page=1');
        $result = $this->processResponse($case, $response);
        return $result ? $result['total_count'] : null;
    }

    /**
     * Method for retrieving repositories closed pull requests count data
     * 
     * @param string $case repository name   
     * @return int with repository closed pull requests count or null
    */

    public function getClosedPullRequestsCount(string $case): ?int
    {
        $response = $this->makeApiCall('GET', $this->search_url . 'issues?q=repo:' . $case. '%20is:pr%20is:closed&per_page=1');
        $result = $this->processResponse($case, $response);
        return $result ? $result['total_count'] : null;
    }
}