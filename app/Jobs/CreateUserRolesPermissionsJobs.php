<?php

namespace App\Jobs;

use App\Models\UserRolePermissions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateUserRolesPermissionsJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;        
    public function __construct($data)
    {   
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        if(is_array($this->data)) {
            UserRolePermissions::insert($this->data);
        } else {
            UserRolePermissions::create($this->data);
        }        
    }
}
