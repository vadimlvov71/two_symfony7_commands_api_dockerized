<?php
namespace ApiApp\Commands;

// 02 Importing the Command base class
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use ApiApp\Services\CurlService;

class CreateUserCommand extends Command
{
    private string $api_host; 
    public function __construct($api_host) {
        parent::__construct();
        $this->api_host = $api_host;

    }
    protected function configure()
    {
        $this
            ->setName('user/new')
            ->setDescription('creation of a new user')
            ->setHelp('input a user name.')
            ->addArgument('name', InputArgument::REQUIRED, 'Who do you want to add?')
            ->addArgument('email', InputArgument::REQUIRED, 'Who do you want to add?')
            ->addArgument('group_name', InputArgument::REQUIRED, 'Who do you want to add?');
    }

    // 09 implementing the execute method
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Creation of a user');
        $name = $input->getArgument('name');
        $email = $input->getArgument('email');
        $group_name = $input->getArgument('group_name');
        $api_url = "/user/new";
        $curlService = new CurlService($this->api_host);
        $data = [ 
            "name" => $name,
            "email" => $email,
            "group_name" => $group_name,

        ]; 
        $response = json_decode($curlService->apiResponse($api_url, $data, "POST"));
        if (isset($response->error_email_exists)) {
            $io->error('this email is exist');
        } else if (isset($response->group_error)){
            $io->error('this group is not exist');
        } else {
            $io->success('user was created successfully');
        } 
        return Command::SUCCESS;
    }

}