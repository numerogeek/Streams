<?php namespace Streams\Command;

use Illuminate\Console\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;

class  UserCreateCommand extends BaseCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $email    = $this->ask('Which email would you like to use? ');
        $password = $this->ask('Which password? ');

        try {
            // Create the user
            \Sentry::createUser(
                array(
                    'email'     => $email,
                    'password'  => $password,
                    'activated' => true,
                )
            );

            $this->info('User created!');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $this->info('Login field is required.');
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $this->info('Password field is required.');
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $this->info('User with this login already exists.');
        } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $this->info('Group was not found.');
        }
    }

}
