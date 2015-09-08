<?php

namespace blackknight467\SmartyStreetsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class USStreetAddressCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('smartystreets:us-verify')
            ->setDescription('verify a united states postal address')
            ->addArgument('street', InputArgument::REQUIRED, 'street')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $street = $input->getArgument('street');

        try {
            $response = $this->getContainer()->get('blackknight467.smarty_streets')->verifyUSStreetAddressText($street);
            $output->writeln($response);
        } catch (\Exception $e) {
            $output->writeln('An error occured, please check your options');
        }


    }
}