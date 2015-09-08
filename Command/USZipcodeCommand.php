<?php

namespace blackknight467\SmartyStreetsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class USZipcodeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('smartystreets:us-zip-verify')
            ->setDescription('verify a zipcode')
            ->addArgument('zipcode', InputArgument::REQUIRED, 'zipcode')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $zipcode = $input->getArgument('zipcode');

        try {
            $response = $this->getContainer()->get('blackknight467.smarty_streets')->verifyTextZipCode($zipcode);
            $output->writeln($response);
        } catch (\Exception $e) {
            $output->writeln('An error occured, please check your options');
        }

    }
}