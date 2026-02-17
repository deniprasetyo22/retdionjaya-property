<?php

use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\ProjectList;
use App\Livewire\ArticleList;
use App\Livewire\Testimonial;
use App\Livewire\ArticleDetail;
use App\Livewire\ProjectDetail;
use App\Livewire\CustomerFeedback;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::get('/project-list', ProjectList::class)->name('project-list');
Route::get('/project/{project:slug}', ProjectDetail::class)->name('project-detail');

Route::get('/article-list', ArticleList::class)->name('article-list');
Route::get('/article/{article:slug}', ArticleDetail::class)->name('article-detail');

Route::get('/testimonials', Testimonial::class)->name('testimonials');

Route::get('/customer-feedback', CustomerFeedback::class)->middleware('throttle:5,1')->name('customer-feedback');

Route::get('/about', About::class)->name('about');

Route::get('/contact', Contact::class)->name('contact');