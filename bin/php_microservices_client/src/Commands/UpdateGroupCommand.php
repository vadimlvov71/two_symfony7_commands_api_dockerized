<?php
namespace ApiApp\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use ApiApp\Services\CurlService;

class UpdateGroupCommand extends Command
{
    private string $api_host; 
    public function __construct($api_host) {
        parent::__construct();
        $this->api_host = $api_host;

    }
    protected function configure()
    {
        $this
            ->setName('group/update')
            ->setDescription('update a group')
            ->setHelp('input a group name.')
            ->addArgument('id', InputArgument::REQUIRED, 'Who do you want to add?')
            ->addArgument('name', InputArgument::REQUIRED, 'Who do you want to add?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getArgument('id');
        $name = $input->getArgument('name');
        $api_url = "/group/update";
        $curlService = new CurlService($this->api_host);
        $data = [ 
            "id" => $id,
            "name" => $name
        ]; 
        $response = $curlService->apiResponse($api_url, $data, "PUT");  
        return Command::SUCCESS;
    }

}