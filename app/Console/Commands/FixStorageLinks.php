<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class FixStorageLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix-links {--hard-copy : Copy files instead of creating symlinks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix storage links for shared hosting environments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing storage links for shared hosting...');

        if ($this->option('hard-copy')) {
            // For environments where symlinks don't work, physically copy files
            $this->info('Using hard copy method (instead of symlinks)');

            $targetFolder = public_path('storage');
            $this->info('Target directory: ' . $targetFolder);

            // Remove existing directory
            if (File::exists($targetFolder)) {
                $this->info('Removing existing target directory...');
                File::deleteDirectory($targetFolder);
            }

            // Create directory if it doesn't exist
            File::makeDirectory($targetFolder, 0755, true, true);

            // Copy the contents from storage/app/public to public/storage
            $sourcePath = storage_path('app/public');
            $this->info('Source directory: ' . $sourcePath);

            if (!File::exists($sourcePath)) {
                File::makeDirectory($sourcePath, 0755, true, true);
                $this->info('Created source directory as it did not exist');
            }

            // Copy all contents from source to target
            File::copyDirectory($sourcePath, $targetFolder);

            $this->info('Files copied successfully! Storage is now accessible.');

            // Create a README file explaining this is a copy
            $readmePath = $targetFolder . '/README.txt';
            $readmeContent = "This directory contains copies of files from storage/app/public.\n";
            $readmeContent .= "It was created with the 'php artisan storage:fix-links --hard-copy' command.\n";
            $readmeContent .= "Date: " . date('Y-m-d H:i:s') . "\n";
            $readmeContent .= "If you're adding or changing files in storage/app/public, please run this command again.\n";

            File::put($readmePath, $readmeContent);

        } else {
            // Try the normal Laravel artisan storage:link command first
            $this->info('Trying standard Laravel storage:link command...');

            try {
                Artisan::call('storage:link');
                $this->info('Standard Laravel symlink created successfully!');
                $this->info(Artisan::output());

            } catch (\Exception $e) {
                $this->error('Could not create standard Laravel symlink: ' . $e->getMessage());
                $this->info('Attempting manual symlink creation...');

                // Try to create the symlink manually
                $target = storage_path('app/public');
                $link = public_path('storage');

                // Ensure the target directory exists
                if (!File::exists($target)) {
                    File::makeDirectory($target, 0755, true, true);
                }

                // Remove the link if it already exists as a directory
                if (File::exists($link)) {
                    if (is_link($link)) {
                        unlink($link);
                    } else {
                        File::deleteDirectory($link);
                    }
                }

                // Create the symlink
                try {
                    symlink($target, $link);
                    $this->info('Manual symlink created successfully!');
                } catch (\Exception $e) {
                    $this->error('Manual symlink creation failed: ' . $e->getMessage());
                    $this->info('Please run again with --hard-copy option.');
                }
            }
        }

        return 0;
    }
}
