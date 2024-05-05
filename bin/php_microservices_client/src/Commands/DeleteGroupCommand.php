<?php
namespace ApiApp\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use ApiApp\Services\CurlService;

class DeleteGroupCommand extends Command
{
    private string $api_host; 
    public function __construct($api_host) {
        parent::__construct();
        $this->api_host = $api_host;

    }
    protected function configure()
    {
        $this
            ->setName('group/delete')
            ->setDescription('delete a new group')
            ->setHelp('input a group id.')
            ->addArgument('id', InputArgument::REQUIRED, 'Who do you want to delete?');
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $id = $input->getArgument('id');
        $api_url = "/group/delete";
        $curlService = new CurlService($this->api_host);
        $data = [ 
            "id" => $id
        ]; 
        $response = $curlService->apiResponse($api_url, $data, "DELETE"); 
        return Command::SUCCESS;
    }

}