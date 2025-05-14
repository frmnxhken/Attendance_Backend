<?php

namespace App\Services\API;

use App\Http\Resources\ExcuseResource;
use App\Models\Excuse;
use Illuminate\Support\Facades\Auth;

class ExcuseService
{
    public function getExcuses() {
        $user = Auth::user();
        $excuses = Excuse::where('user_id' , $user->id)->get();
        return ExcuseResource::collection($excuses);
    }

    public function createExcuse(array $data)
    {
        $filePath = $this->saveProof($data['proof']);

        return Excuse::create([
            'user_id' => Auth::id(),
            'reason' => $data['reason'],
            'proof' => $filePath,
            'date' => $data['date'],
            'status' => 'pending',
        ]);
    }

    protected function saveProof($file)
    {
        $folder = 'uploads/excuse';
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $filename);
        return $folder . '/' . $filename;
    }
}
