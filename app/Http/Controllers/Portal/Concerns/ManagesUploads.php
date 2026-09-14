<?php

namespace App\Http\Controllers\Portal\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Uploaded files live on the public disk and are recorded as "storage/..." paths, so the models can
 * pass them to asset() exactly like the bundled "images/..." photographs.
 */
trait ManagesUploads
{
    protected function storeUpload(?UploadedFile $file, string $directory): ?string
    {
        return $file ? 'storage/'.$file->store($directory, 'public') : null;
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @return list<string>
     */
    protected function storeUploads(array $files, string $directory): array
    {
        return array_values(array_map(fn (UploadedFile $file): string => $this->storeUpload($file, $directory), $files));
    }

    /**
     * Delete uploaded files. Bundled images under public/images are never touched.
     *
     * @param  string|array<int, string>|null  $paths
     */
    protected function deleteUploads(string|array|null $paths): void
    {
        foreach ((array) $paths as $path) {
            if (is_string($path) && str_starts_with($path, 'storage/')) {
                Storage::disk('public')->delete(Str::after($path, 'storage/'));
            }
        }
    }

    /**
     * Keep the gallery images that were not ticked for removal, then append the new uploads.
     *
     * @param  list<string>|null  $current
     * @param  list<string>  $removed
     * @param  array<int, UploadedFile>  $uploads
     * @return list<string>
     */
    protected function syncGallery(?array $current, array $removed, array $uploads, string $directory): array
    {
        $current = $current ?? [];
        $removed = array_values(array_intersect($current, $removed));

        $this->deleteUploads($removed);

        return [
            ...array_values(array_diff($current, $removed)),
            ...$this->storeUploads($uploads, $directory),
        ];
    }
}
