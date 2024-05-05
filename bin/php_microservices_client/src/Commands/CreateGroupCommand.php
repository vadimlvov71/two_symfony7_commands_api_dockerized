<?php
namespace ApiApp\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use ApiApp\Services\CurlService;

class CreateGroupCommand extends Command
{
    private string $api_host; 
    public function __construct($api_host) {
        parent::__construct();
        $this->api_host = $api_host;

    }
    protected function configure()
    {
        $this
            ->setName('group/new')
            ->setDescription('creation a new group')
            ->setHelp('input ag roup name.')
            ->addArgument('name', InputArgument::REQUIRED, 'Who do you want to add?');
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $name = $input->getArgument('name');
        $api_url = "/group/new";
        $curlService = new CurlService($this->api_host);
        $data = [ 
            "name" => $name
        ]; 
        $response = $curlService->apiResponse($api_url, $data, "POST"); 
        return Command::SUCCESS;
    }

}