@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12 gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                    <span class="text-indigo-600">Movie</span> Explorer
                </h1>
                <p class="text-gray-500 mt-2">{{ trans('messages.subtitle') }}</p>
            </div>

            <form method="GET" action="{{ route('movies.list') }}" class="relative w-full md:w-1/3 group">
                <input type="text" name="q" value="{{ $query }}" placeholder="{{ trans('messages.search_placeholder') }}"
                    class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 outline-none">
                <div class="absolute left-4 top-3.5 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="submit" class="hidden">Search</button>
            </form>
        </div>

        <div id="movies" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @forelse($movies['Search'] ?? [] as $movie)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden flex flex-col border border-gray-100">

                    <div class="relative aspect-[2/3] overflow-hidden">
                        <a href="{{ route('movies.detail', $movie['imdbID']) }}">
                            <img class="lazy w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                data-src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : '' }}" alt="{{ $movie['Title'] }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full bg-gray-100 text-gray-400 justify-center items-center text-sm font-medium p-4 text-center">
                                {{ trans('messages.img_not_available') }}
                            </div>
                        </a>

                        <div class="absolute top-3 left-3">
                            <span class="bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                                {{ $movie['Year'] }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-gray-800 text-md leading-tight mb-4 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $movie['Title'] }}
                        </h3>

                        <div class="mt-auto flex gap-2">
                            <a href="{{ route('movies.detail', $movie['imdbID']) }}"
                                class="flex-1 text-center py-2 bg-gray-100 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium text-xs rounded-xl transition-colors">
                                {{ trans('messages.details') }}
                            </a>
                            <button
                                class="favorite p-2 bg-gray-100 hover:bg-rose-50 text-gray-400 hover:text-rose-500 rounded-xl transition-all duration-300"
                                data-movie='@json($movie)'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="text-gray-300 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <p class="text-xl text-gray-500 font-medium">{{ trans('messages.no_movies') }}</p>
                </div>
            @endforelse
        </div>

        @if(!empty($movies['Search']))
            <div class="mt-16 text-center">
                <button id="loadMore" data-page="{{ $page }}"
                    class="inline-flex items-center px-8 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-bold rounded-full hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-md">
                    {{ trans('messages.load_more') }}
                </button>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function lazyLoad() {
            $('img.lazy').each(function () {
                var src = $(this).data('src');
                if(src) {
                    $(this).attr('src', src);
                    $(this).removeClass('lazy').addClass('opacity-100');
                }
            });
        }

        $(document).ready(function () {
            lazyLoad();

            // Load More dengan Terjemahan JS
            $('#loadMore').click(function () {
                let btn = $(this);
                let originalText = "{{ trans('messages.load_more') }}";
                let loadingText = "{{ trans('messages.loading') }}";
                
                btn.html(loadingText).prop('disabled', true);
                
                var page = btn.data('page') + 1;
                var query = '{{ $query }}';

                $.get('?q=' + query + '&page=' + page, function (data) {
                    let newContent = $(data).find('#movies').html();
                    $('#movies').append(newContent);
                    btn.data('page', page);
                    btn.html(originalText).prop('disabled', false);
                    lazyLoad();
                }).fail(function() {
                    btn.html(originalText).prop('disabled', false);
                });
            });

            // Favorite dengan Alert Terjemahan
            $(document).on('click', '.favorite', function () {
                let btn = $(this);
                var movie = btn.data('movie');
                
                $.post("{{ route('favorite.add') }}", movie, function () {
                    btn.addClass('bg-rose-500 text-white').removeClass('text-gray-400 bg-gray-100');
                    btn.find('svg').attr('fill', 'currentColor');
                    // Menggunakan alert dari file bahasa
                    alert("{{ trans('messages.saved_to_fav') }}");
                });
            });
        });
    </script>
@endsection