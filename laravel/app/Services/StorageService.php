<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function upload($request, $fieldName, $folder)
    {
        if ($request->hasFile($fieldName)) {
            $request->validate([
                $fieldName => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5096',
            ]);
            $fileUrl = \Storage::disk('public')->put($folder, $request->file($fieldName));

            return $fileUrl;
        }
    }

    public function delete($fileUrl)
    {
        if (Storage::disk('public')->exists($fileUrl)) {
            Storage::disk('public')->delete($fileUrl);
        }
    }
}
