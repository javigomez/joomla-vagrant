<?php
namespace Command\Xdebug;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

class Enable extends Xdebug
{
    protected function configure()
    {
        $this->setName('xdebug:enable')
             ->setDescription('Enable Xdebug');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $files = \Helper\Ini::findIniFiles($this->_ini_files);

        foreach($files as $file) {
            `sudo sed -i 's#^; zend_extension=#zend_extension=#' $file`;
        }

        $this->getApplication()->find('server:restart')->run(new ArrayInput(array('command' => 'server:restart', 'service' => array('apache'))), $output);

        $output->writeln('Xdebug has been enabled');
    }
}