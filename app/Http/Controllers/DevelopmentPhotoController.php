<?php

namespace App\Http\Controllers;

use App\Models\Development;
use App\Models\DevelopmentPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DevelopmentPhotoController extends Controller
{
    public function index(Development $development): View
    {
        $photos = $development->photos()
            ->latest('date')
            ->latest('id')
            ->paginate(12);

        return view('developments.photos.index', compact('development', 'photos'));
    }

    public function create(Development $development): View
    {
        $photo = new DevelopmentPhoto();

        return view('developments.photos.create', compact('development', 'photo'));
    }

    public function store(Request $request, Development $development): RedirectResponse
    {
        $validated = $this->validatePhoto($request, true);
        $path = $validated['image']->store('development-photos', 'public');

        $development->photos()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'date' => $validated['date'] ?? null,
            'image_path' => $path,
        ]);

        return redirect()
            ->route('developments.photos.index', $development)
            ->with('success', 'Foto da obra cadastrada com sucesso.');
    }

    public function edit(Development $development, DevelopmentPhoto $photo): View
    {
        $this->ensureBelongsToDevelopment($development, $photo);

        return view('developments.photos.edit', compact('development', 'photo'));
    }

    public function update(Request $request, Development $development, DevelopmentPhoto $photo): RedirectResponse
    {
        $this->ensureBelongsToDevelopment($development, $photo);

        $validated = $this->validatePhoto($request, false);
        $payload = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'date' => $validated['date'] ?? null,
        ];

        if (isset($validated['image'])) {
            Storage::disk('public')->delete($photo->image_path);
            $payload['image_path'] = $validated['image']->store('development-photos', 'public');
        }

        $photo->update($payload);

        return redirect()
            ->route('developments.photos.index', $development)
            ->with('success', 'Foto da obra atualizada com sucesso.');
    }

    public function destroy(Development $development, DevelopmentPhoto $photo): RedirectResponse
    {
        $this->ensureBelongsToDevelopment($development, $photo);
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return redirect()
            ->route('developments.photos.index', $development)
            ->with('success', 'Foto da obra removida com sucesso.');
    }

    protected function validatePhoto(Request $request, bool $imageRequired): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:5120'],
        ];

        return $request->validate($rules);
    }

    protected function ensureBelongsToDevelopment(Development $development, DevelopmentPhoto $photo): void
    {
        abort_unless($photo->development_id === $development->id, 404);
    }
}
