<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteUnlinkedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unlinked-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete images that do not have an imageable_id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $images = Image::whereNull('imageable_id')->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $this->info('Unlinked images deleted successfully.');
    }
}
