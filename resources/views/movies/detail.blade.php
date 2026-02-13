@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-6 sm:mt-10 px-4 pb-20">
    <a href="{{ route('movies.list') }}" class="lang-link inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-6 transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ trans('messages.back_to_list') }}
    </a>

    <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100 flex flex-col md:flex-row">
        
        <div class="w-full md:w-1/3 relative group">
            <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/600x900?text=' . urlencode(trans('messages.img_not_available')) }}" 
                 alt="{{ $movie['Title'] }}" 
                 class="w-full h-full object-cover shadow-inner">
            <div class="absolute top-4 right-4 bg-yellow-400 text-black font-black px-3 py-1 rounded-lg shadow-xl flex items-center gap-1">
                <span>⭐</span> {{ $movie['imdbRating'] ?? 'N/A' }}
            </div>
        </div>

        <div class="w-full md:w-2/3 p-8 md:p-12 flex flex-col">
            <div class="mb-6">
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight mb-2">
                    {{ $movie['Title'] }}
                </h1>
                <div class="flex flex-wrap gap-3 text-sm font-medium text-gray-500">
                    <span class="px-3 py-1 bg-gray-100 rounded-full">{{ $movie['Year'] }}</span>
                    <span class="px-3 py-1 bg-gray-100 rounded-full">{{ $movie['Runtime'] ?? 'N/A' }}</span>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full">{{ $movie['Rated'] ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-8">
                @foreach(explode(',', $movie['Genre'] ?? '') as $genre)
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400 border border-gray-200 px-3 py-1 rounded-md">
                        {{ trim($genre) }}
                    </span>
                @endforeach
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-2 italic border-l-4 border-indigo-600 pl-4">
                    {{ trans('messages.synopsis') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-lg">
                    {{ $movie['Plot'] }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm border-t border-gray-100 pt-8">
                <div>
                    <span class="block text-gray-400 uppercase text-[10px] font-bold tracking-widest mb-1">{{ trans('messages.director') }}</span>
                    <span class="text-gray-800 font-semibold">{{ $movie['Director'] ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 uppercase text-[10px] font-bold tracking-widest mb-1">{{ trans('messages.writer') }}</span>
                    <span class="text-gray-800 font-semibold">{{ $movie['Writer'] ?? 'N/A' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-gray-400 uppercase text-[10px] font-bold tracking-widest mb-1">{{ trans('messages.actors') }}</span>
                    <span class="text-gray-800 font-semibold">{{ $movie['Actors'] ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap gap-4">
                <button id="addFavorite" 
                        data-movie='@json($movie)'
                        class="flex-1 sm:flex-none inline-flex justify-center items-center gap-2 bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    {{ trans('messages.add_to_fav') }}
                </button>
                
                <button class="flex-1 sm:flex-none inline-flex justify-center items-center gap-2 bg-gray-100 text-gray-700 px-8 py-4 rounded-2xl font-bold hover:bg-gray-200 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    {{ trans('messages.share') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#addFavorite').click(function(e){
        e.preventDefault();
        let btn = $(this);
        var movie = btn.data('movie');
        
        let processingText = "{{ trans('messages.processing') }}";
        let savedText = "❤️ {{ trans('messages.saved') }}";
        let successTemplate = "{{ trans('messages.fav_success', ['title' => 'MOVIE_TITLE']) }}";
        
        btn.html(processingText).prop('disabled', true);
        
        $.post("{{ route('favorite.add') }}", movie, function(){
            btn.html(savedText);
            btn.removeClass('bg-indigo-600').addClass('bg-rose-500');
            
            alert(successTemplate.replace('MOVIE_TITLE', movie.Title));
        }).fail(function() {
            btn.html("{{ trans('messages.add_to_fav') }}").prop('disabled', false);
            alert('Error!');
        });
    });
});
</script>
@endsection