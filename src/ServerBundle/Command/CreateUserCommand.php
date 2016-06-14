<?php

namespace ServerBundle\Command;

use ServerBundle\Model\User;
use ServerBundle\ServerBundle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $name = ServerBundle::COMMAND_PREFIX . ':user:create';
        $this
            ->setName($name)
            ->setDescription('Creates an admin account.');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');

        $username = $dialog->ask(
            $output,
            'Please enter your username: '
        );

        $password = $dialog->askHiddenResponse(
            $output,
            'Choose a password, please: ',
            false
        );

        $passwordConfirm = $dialog->askHiddenResponse(
            $output,
            'Confirm this password: ',
            false
        );

        if ($password !== $passwordConfirm) {
            throw new \Exception('Passwords did not match.');
        }

        $encoder = $this->getContainer()->get('security.password_encoder');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setRole(User::ROLE_ADMIN);

        $this->getContainer()->get('doctrine.orm.default_entity_manager')->persist($user);
        $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();

        $output->writeln('SUCCESS! User was successfully created.');
    }

}