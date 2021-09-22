<?php namespace Bizmark\Hamovniky\Console;

use Illuminate\Console\Command;
use October\Rain\Network\Http;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CianUpdate extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'hamovniky:cianupdate';

    /**
     * @var string The console command description.
     */
    protected $description = 'Update CIAN';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjI1NTUzNzh9.0g2RbP3U239fjWF2zXZ_uaSurjPuWgauxvPaW6RAf_c';
        $response = Http::get('https://public-api.cian.ru/v1/get-my-offers?statuses=published', function ($http) use ($token) {
            $http->header('Authorization', 'Bearer '.$token);
        });
        $response = json_decode($response);

        foreach ($response->result->announcements as $item) {
            $this->info($item->id);
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
