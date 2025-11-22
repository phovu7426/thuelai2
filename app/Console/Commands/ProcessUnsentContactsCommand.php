<?php

namespace App\Console\Commands;

use App\Jobs\ProcessUnsentContacts;
use Illuminate\Console\Command;

class ProcessUnsentContactsCommand extends Command
{
    protected $signature = 'contacts:process-unsent';
    protected $description = 'Dispatch job xử lý các contact chưa gửi mail';

    public function handle()
    {
        $this->info('Dispatching job ProcessUnsentContacts...');
        
        ProcessUnsentContacts::dispatch();
        
        $this->info('Job đã được dispatch thành công!');
        $this->info('Job sẽ chạy bất đồng bộ trong queue.');
    }
} 