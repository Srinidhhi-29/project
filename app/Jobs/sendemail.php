<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Tmail;

class sendemail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;
    // protected  // Define a protected $data property

    /**
     * Create a new job instance.
     * 
     *
     * @param array $data
     */
    public function __construct(array $data) // Accept $data in the constructor
    {
        $this->data = $data; // Assign $data to the class property
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $mail = new Tmail($this->data); // Use $this->data here
        Mail::to($this->data['owner_email'])->send($mail); // Send email to the 'owner_email'
    }
}
 