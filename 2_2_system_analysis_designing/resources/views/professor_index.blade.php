<x-app>
    <div class="flex items-center justify-center my-8">
        <div class="flex h-full max-w-screen-2xl w-full">
            <div class="w-1/5 px-4">
                <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-400">

                </div>
                <p class="my-5 font-bold text-2xl">{{$prof?->name}}</p>
                <ul class="border-y border-gray-400 grid grid-cols-3 gap-3 py-4">
                    <li>
                        <span class="text-gray-400 text-sm text-center block">수강생수</span>
                        <p class="font-bold text-center">{{$sub_count}}</p>
                    </li>
                    <li>
                        <span class="text-gray-400 text-sm text-center block">수강평수</span>
                        <p class="font-bold text-center">{{$review_count}}</p>
                    </li>
                    <li>
                        <span class="text-gray-400 text-sm text-center block">강의평점</span>
                        <p class="font-bold text-center">⭐{{$rating_average}}</p>
                    </li>
                </ul>
            </div>
            <div class="w-0.5 h-full bg-gray-200"></div>
            <div class="w-4/5 px-5 py-4">
                <div class="flex items-center justify-between pb-16">
                    <p class="text-4xl font-bold">강의</p>
                    @if(Auth::check() && Auth::id() === $prof->id)
                        <a href="{{route('professor.create_lecture')}}" class="px-3 py-3 rounded-lg bg-primary text-white">강의 만들기</a>
                    @endif
                </div>
                <div class="{{$lecture_rooms->isEmpty() ? "" : "grid grid-cols-4 gap-4"}}">
                    @foreach($lecture_rooms as $room)
                        <x-lecture-card
                            image="{{asset($room->thumbnail)}}"
                            title="{{$room->title}}"
                            id="{{$room->id}}"
                            review_count="{{$room->reviews->count()}}"
                            rating="{{round($room->reviews->avg('rating'), 1) ?? 0}}"
                        />
                    @endforeach
                    @if($lecture_rooms->isEmpty())
                        <p class="w-full h-60 rounded-2xl border border-gray-400 flex items-center justify-center">개설한 강의가 없습니다.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app>
