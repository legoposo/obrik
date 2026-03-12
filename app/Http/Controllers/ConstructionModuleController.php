<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Development;
use App\Models\DevelopmentPhoto;
use App\Models\DevelopmentStage;
use Illuminate\View\View;

class ConstructionModuleController extends Controller
{
    public function stages(): View
    {
        $developments = Development::query()
            ->withCount([
                'stages',
                'stages as completed_stages_count' => fn ($query) => $query->where('status', 'concluido'),
                'stages as in_progress_stages_count' => fn ($query) => $query->where('status', 'em_andamento'),
            ])
            ->orderBy('name')
            ->paginate(12);

        $stats = [
            'total_stages' => DevelopmentStage::count(),
            'completed_stages' => DevelopmentStage::query()->where('status', 'concluido')->count(),
            'in_progress_stages' => DevelopmentStage::query()->where('status', 'em_andamento')->count(),
            'developments_with_stages' => Development::query()->whereHas('stages')->count(),
        ];

        return view('construction.stages', compact('developments', 'stats'));
    }

    public function communications(): View
    {
        $developments = Development::query()
            ->withCount('communications')
            ->orderByDesc('communications_count')
            ->orderBy('name')
            ->paginate(12);

        $recentCommunications = Communication::query()
            ->with('development:id,name')
            ->latest('created_at')
            ->take(8)
            ->get();

        $stats = [
            'total_communications' => Communication::count(),
            'developments_with_communications' => Development::query()->whereHas('communications')->count(),
        ];

        return view('construction.communications', compact('developments', 'recentCommunications', 'stats'));
    }

    public function photos(): View
    {
        $developments = Development::query()
            ->withCount('photos')
            ->orderByDesc('photos_count')
            ->orderBy('name')
            ->paginate(12);

        $recentPhotos = DevelopmentPhoto::query()
            ->with('development:id,name')
            ->latest('date')
            ->latest('id')
            ->take(9)
            ->get();

        $stats = [
            'total_photos' => DevelopmentPhoto::count(),
            'developments_with_photos' => Development::query()->whereHas('photos')->count(),
        ];

        return view('construction.photos', compact('developments', 'recentPhotos', 'stats'));
    }
}