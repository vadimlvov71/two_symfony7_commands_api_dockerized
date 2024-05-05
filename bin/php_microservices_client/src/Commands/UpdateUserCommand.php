<?php
namespace ApiApp\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Output\OutputInterface;

use ApiApp\Services\CurlService;

class UpdateUserCommand extends Command
{
    private string $api_host; 
    public function __construct($api_host) {
        parent::__construct();
        $this->api_host = $api_host;

    }
    protected function configure()
    {
        $this
            ->setName('user/update')
            ->setDescription('update of a user')
            ->addArgument('id_user', InputArgument::REQUIRED)
            ->addArgument('second_argument')
            ->addOption('action', null, InputOption::VALUE_REQUIRED);
           
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $actions = ["user", "group"];
        $data = [];
        $io = new SymfonyStyle($input, $output);
        $io->title('Updating a user');
       
        $id_user = $input->getArgument('id_user');
        $second_argument = $input->getArgument('second_argument');
        $action = $input->getOption('action');

        if (!in_array($action, $actions)){
            $io->error('"--action=value" value must be "user" or "group"');
        } else if (!isset($second_argument)){
            $io->error(' after "--action=value" must be "a new name of a user" or "group"');
        }  else if (!is_numeric($id_user)){
            $io->error('id_user must be a number');
        } else if ($action == "group" && !is_numeric($second_argument)){
            $io->error(' id_group must be a number');
        } else {
            $data["id_user"] = $id_user;
            $data["action"] = $action;
            if ($action == "user") {
                $data["name"] = $second_argument;
            } else {
                $data["id_group"] = $second_argument;
            }
    
            $api_url = "/user/update";
            $curlService = new CurlService($this->api_host);
    
            $response = json_decode($curlService->apiResponse($api_url, $data, "PATCH"));
      
            if (isset($response->error->no_user)) {
                $io->error('user no found');
            } else {
                $io->success('updated successfully');
            }
            
            
        }
        return Command::SUCCESS;
    }

}