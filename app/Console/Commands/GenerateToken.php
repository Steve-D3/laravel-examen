<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:generate {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a token for API testing';
    
    /**
     * The string to append to the email for token generation.
     *
     * @var string
     */
    protected $salt = 'canadarocks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Please provide a valid email address.');
            return 1;
        }
        
        $token = md5($email . $this->salt);
        
        $this->info("Email: " . $email);
        $this->info("Token: " . $token);
        $this->newLine();
        
        $curlExample = "curl -X POST http://your-app-url/api/bookings \\
    -H \"Content-Type: application/json\" \\
    -d '{
        \"trip_id\": 1,
        \"name\": \"Test User\",
        \"email\": \"$email\",
        \"number_of_people\": 2,
        \"token\": \"$token\"
    }'";
        
        $this->info('Example curl command:');
        $this->line($curlExample);
        
        return 0;
    }
}
