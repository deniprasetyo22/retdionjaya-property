<?php

namespace App\Filament\Widgets;

use App\Models\Bank;
use App\Models\Article;
use App\Models\Message;
use App\Models\Brochure;
use App\Models\Property;
use App\Models\Residence;
use App\Models\Testimonial;
use App\Models\CustomerData;
use App\Models\CompanyProfile;
use App\Models\CustomerFeedback;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Artikel', Article::count())
                ->icon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Umpan Balik', CustomerFeedback::count())
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success'),

            Stat::make('Pesan', Message::count())
                ->icon('heroicon-o-envelope')
                ->color('danger'),

            Stat::make('Proyek', Project::count())
                ->icon('heroicon-o-home-modern')
                ->color('primary'),

            Stat::make('Testimoni', Testimonial::count())
                ->icon('heroicon-o-hand-thumb-up')
                ->color('warning'),
        ];
    }
}