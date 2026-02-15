@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
            {{-- Menggunakan lang untuk judul --}}
            {{ explode(' ', trans('messages.favorites'))[0] }} <span class="text-rose-600">{{ explode(' ', trans('messages.favorites'))[1] ?? '' }}</span>
        </h1>
        <p class="text-gray-500 mt-2">{{ trans('messages.favorite_subtitle') }}</p>
    </div>

    <div id="favorites-list" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
        @forelse($favorites as $movie)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden flex flex-col border border-gray-100" 
                 id="movie-{{ $movie['imdbID'] }}">
                
                <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                    <a href="{{ route('movies.detail', $movie['imdbID']) }}">
                        {{-- Logika Gambar: Ditambahkan placeholder transparan agar tidak terlihat pecah sebelum dimuat --}}
                        <img class="lazy w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-0 transition-opacity duration-500"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
                            data-src="{{ ($movie['Poster'] != 'N/A' && !empty($movie['Poster'])) ? $movie['Poster'] : '' }}" 
                            alt="{{ $movie['Title'] }}"
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
                    <h3 class="font-bold text-gray-800 text-md leading-tight mb-4 line-clamp-2 group-hover:text-rose-600 transition-colors">
                        {{ $movie['Title'] }}
                    </h3>

                    <div class="mt-auto flex gap-2">
                        <a href="{{ route('movies.detail', $movie['imdbID']) }}"
                            class="flex-1 text-center py-2 bg-gray-100 hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium text-xs rounded-xl transition-colors">
                            {{ trans('messages.details') }}
                        </a>
                        
                        <button
                            class="remove-favorite p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all duration-300"
                            data-id="{{ $movie['imdbID'] }}"
                            title="{{ trans('messages.confirm_remove') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-xl text-gray-500 font-medium">{{ trans('messages.no_favorites') }}</p>
                <a href="{{ route('movies.list') }}" class="mt-6 inline-block text-indigo-600 font-bold hover:underline">
                    {{ trans('messages.browse_movies') }}
                </a>
            </div>
        @endforelse
    </div>
</div>

<script>
    function lazyLoad() {
        $('img.lazy').each(function () {
            var $img = $(this);
            var src = $img.data('src');
            if (src && src !== '') {
                $img.attr('src', src).removeClass('lazy').addClass('opacity-100');
            } else {
                // Jika URL gambar kosong dari API
                $img.hide();
                $img.next().css('display', 'flex');
            }
        });
    }

    $(document).ready(function () {
        // Eksekusi sedikit lebih lambat untuk memastikan transisi opacity berjalan manis
        setTimeout(lazyLoad, 100);

        $('.remove-favorite').click(function () {
            let btn = $(this);
            let imdbID = btn.data('id');

            // Menggunakan konfirmasi multibahasa
            if (confirm("{{ trans('messages.confirm_remove') }}")) {
                $.post("{{ route('favorite.remove') }}", { 
                    imdbID: imdbID 
                }, function (response) {
                    if (response.success) {
                        $(`#movie-${imdbID}`).fadeOut(400, function() {
                            $(this).remove();
                            // Jika list kosong setelah dihapus, refresh untuk memunculkan pesan "Empty"
                            if ($('#favorites-list').children(':visible').length === 0) {
                                location.reload(); 
                            }
                        });
                    }
                });
            }
        });
    });
</script>

<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection