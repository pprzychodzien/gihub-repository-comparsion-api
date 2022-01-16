<?php

declare (strict_types = 1);

namespace App\Service\Api;

use Github\Client;
use App\Service\Api\Validator\RepositoryComparePayloadValidator;
use App\Service\GithubApi\GithubApiService;

class CompareRepositoriesService
{
    /**
     * @var RepositoryComparePayloadValidator
     */
    private $validator;

    /**
     * @var GithubApiService
     */
    private $githubApiService;

    public function __construct(RepositoryComparePayloadValidator $validator, GithubApiService $githubApiService)
    {
        $this->validator = $validator;
        $this->githubApiService = $githubApiService;
    }

    public function validateAndCompare(array $data): array
    {
        $errors = $this->validator->validatePayload($data);
        if (empty($errors)){
            return $this->compare($data);
        }
        return ["errors" => $errors];
    }

    public function compare(array $data = []): array
    {
        $comparsion = [];

        foreach($data['repositories'] as $case){
            if (preg_match('^(http(s)?://github.com)/([a-zA-z0-9-_])*/([a-zA-z0-9-_])*(.git)?^', $case, $matches)){
                $case = ltrim(parse_url(str_replace(".git", "", $case))["path"], '/');
            }
            
            $repoStatistics = $this->githubApiService->getRepo($case);
            $comparsion = $this->addStatisticsToComparsion($case, $repoStatistics, $comparsion);
        }
        return $this->addWinners($comparsion);
    }
    private function addStatisticsToComparsion(string $case, ?array $statistics, array $comparsion): array
    {
        if ($statistics){
            $comparsion['forks'][$case] = $statistics['forks'];
            $comparsion['stars'][$case] = $statistics['stargazers_count'];
            $comparsion['watchers'][$case] = $statistics['watchers'];
            $comparsion['latest_release'][$case] = $this->githubApiService->getLastReleaseDate($case);
            $comparsion['open_pull_requests'][$case] = $this->githubApiService->getOpenPullRequestsCount($case);
            $comparsion['closed_pull_requests'][$case] = $this->githubApiService->getClosedPullRequestsCount($case);
        }else{
            $comparsion['forks'][$case] = 0;
            $comparsion['stars'][$case] = 0;
            $comparsion['watchers'][$case] = 0;
            $comparsion['latest_release'][$case] = 0;
            $comparsion['open_pull_requests'][$case] = 0;
            $comparsion['closed_pull_requests'][$case] = 0;
        }

        return $comparsion;
    }

    private function addWinners(array $comparsion): array
    {
        foreach($comparsion as $category => $competitors){
            if (\array_values($competitors)[0] > \array_values($competitors)[1]){
                $comparsion[$category]['winner'] = \array_keys($competitors)[0];
            }elseif(\array_values($competitors)[0] < \array_values($competitors)[1]){

                $comparsion[$category]['winner'] = \array_keys($competitors)[1];
            }else{
                $comparsion[$category]['winner'] = 'draw';
            } 
        }
        $count_winners = \array_count_values(array_column($comparsion, 'winner'));
        $maxs = \array_keys($count_winners, max($count_winners));
        if(\count($maxs) > 1){
            $comparsion['winner'] = 'draw';
        }else{
            $comparsion['winner'] = $maxs[0];
        }
        return $comparsion;
    }

}
