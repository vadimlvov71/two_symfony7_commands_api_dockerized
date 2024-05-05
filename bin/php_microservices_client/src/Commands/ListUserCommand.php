<?php
namespace ApiApp\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

use ApiApp\Services\CurlService;

class ListUserCommand extends Command
{
    private string $api_host; 
    public function __construct($api_host) {
        parent::__construct();
        $this->api_host = $api_host;

    }
    protected function configure()
    {
        $this
            ->setName('user/list')
            ->setDescription('list of users');
           // ->addArgument('id_user', InputArgument::REQUIRED)

    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        $data = [];
        $io = new SymfonyStyle($input, $output);
        $io->title('List of users');    

        $section = $output->section();
        $table = new Table($section);
        $table->setHeaderTitle('Users');
        $table->setHeaders(['Id', 'Name', 'Email', 'Group_id']);

        $api_url = "/user/list";
        $curlService = new CurlService($this->api_host);

        $response = json_decode($curlService->apiResponse($api_url, $data, "GET"));
        $rows = (array) $response;
        
            
            foreach ($rows as $key => $row) {
                //print_r($row->name);
                $table->addRows([[$row->id, $row->name]]);
               // $table->TableSeparator(),
                if(is_object($row)){
                    foreach ($row as $value) {
       
                        if(is_array($value)){
                            foreach ($value as $user) {
                            // print_r($value);
                            $table->addRows([[$user->id, $user->name, $user->email, $user->group]]);
                            }
                        }
                    }
                }
                
            }
            $table->render(); 
        
        if (isset($response->error->no_user)) {
            $io->error('user no found');
        } 
            
  #$table->addRows([[$value->id, $value->name, $value->email, $value->group]]);          
   
        return Command::SUCCESS;
    }

}