{{--{{dd($review_count)}}--}}

@props([
    'image',
    'title',
    'review_count' => 0,
    'rating' => 0,
    'id'
])

<div class="rounded-2xl overflow-hidden border border-gray-300 shadow-sm max-w-72" data-id="{{$id}}" data-review="{{$review_count}}" data-rating="{{$rating}}">
    <div>
        <img src="{{$image}}" alt="강의 이미지">
    </div>
    <div class="p-4 h-36 flex flex-col justify-between">
        <a class="font-bold text-xl  line-clamp-2" href="{{route('lecture_main', ['id' => $id])}}">{{$title}}</a>
        <div class="flex justify-between items-center">
            <p class="text-gray-400">강의평 {{$review_count ?? "0"}}개</p>
            <p class="text-white bg-primary p-1 pr-2 rounded-md">⭐ {{$rating ?? "0.0"}}</p>
        </div>
    </div>
</div>
