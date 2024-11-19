<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostFeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\NewsletterSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/feed', [PostFeedController::class, 'index'])->name('posts.feed');
Route::resource('posts', PostController::class); // Handles all actions: index, show, create, store, edit, update, destroy
Route::resource('users', UserController::class)->only('show');
Route::resource('posts.comments', PostCommentController::class)->only('index');

Route::get('newsletter-subscriptions/unsubscribe', [NewsletterSubscriptionController::class, 'unsubscribe'])->name('newsletter-subscriptions.unsubscribe');
