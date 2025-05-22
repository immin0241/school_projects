<x-app>
    @php
        if(Auth::check()) {
            $is_subscripted = Auth::user()->subscriptions->contains('lecture_room_id', $lecture->id);
        }
    @endphp
    <div class="flex items-center justify-center bg-neutral-900 text-white">
        <div class="max-w-screen-xl w-full py-10 flex justify-between">
            <div class="w-4/6">
                <h1 class="font-bold text-3xl">{{$lecture->title}}</h1>
                <span class="text-gray-400 w-5/6 pt-2 block">{{$lecture->description}}</span>
                <div class="h-0.5 w-full bg-gray-600 block my-5"></div>
                <p>{!! print_stars($lecture->reviews->avg('rating')) !!} ({{round($lecture->reviews->avg('rating'), 1)}})
                    수강평 {{$lecture->reviews->count()}}개 수강생 {{number_format($lecture->subscriptions->count())}}명
                </p>
                <a href="/professor/{{$lecture->professor_id}}" class="mb-4 block">👤{{$lecture->professor->name}}</a>
                <div class="flex mt-4">
                    @if(Auth::check() && Auth::id() == $lecture->professor_id)
                        <a href="{{route('professor.edit_lecture_view', $lecture->id)}}" class="px-4 py-3 rounded-lg border border-primary flex items-center justify-center flex-1">관리하기</a>
                    @else
                        @if($is_subscripted ?? false)
                            <a href="{{route('unsubscribe', $lecture->id)}}" class="px-4 py-3 rounded-lg bg-primary flex items-center justify-center flex-1">구독 취소하기</a>
                        @else
                            <a href="{{route('subscribe', $lecture->id)}}" class="px-4 py-3 rounded-lg bg-primary flex items-center justify-center flex-1">구독하기</a>
                        @endif
                    @endif

                    <div class="w-4"></div>
                </div>
            </div>
            <div class="rounded overflow-hidden">
                <img src="{{asset($lecture->thumbnail)}}" class="object-contain w-[344px] h-[252px]">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center py-20">
        <div class="max-w-screen-xl w-full">
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-2xl">강좌 목록</h1>
                @if((Auth::user()?->type === "02") && (Auth::id() === $lecture->professor_id))
                    <a href="{{route('lecture.upload_view', ["id" => $lecture->id])}}" class="px-4 py-3 rounded-lg bg-primary flex items-center justify-center text-white">강의 업로드</a>
                @endif
            </div>
            <ul class="mt-4 rounded-xl border border-gray-200">
                @foreach($lecture->lectures as $lecture_videos)
                    <li class="p-4 border-b border-gray-200">
                        <a href="/lecture/view/{{$lecture_videos->id}}">▶️&nbsp;&nbsp;{{$lecture_videos->title}}</a>
                    </li>
                @endforeach
                @if($lecture->lectures->isEmpty())
                    <li class="p-4 border-b border-gray-200 h-32 flex items-center justify-center">업로드된 강좌가 없습니다.</li>
                @endempty
            </ul>
        </div>
    </div>

    <div class="flex items-center justify-center pt-10 pb-20">
        <div class="max-w-screen-xl w-full">
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-2xl">강의평</h1>
            </div>

            @if(($is_subscripted ?? false) && !($lecture->reviews->where('student_id', Auth::id())->where('lecture_room_id', $lecture->id)->count() > 0))
                <form action="{{route('review')}}" method="POST" class="w-full h-40 border border-gray-300 rounded-xl mt-5 flex p-5">
                    @csrf
                    <input type="hidden" name="lecture_room_id" value="{{$lecture->id}}">
                    <textarea name="comment" class="w-11/12 border-none resize-none bg-gray-200 rounded-xl" placeholder="강의평 입력..."></textarea>

                    <div class="w-1/12 pl-2">
                        <select name="rating" id="" class="rounded-md w-full">
                            <option value="5">⭐5</option>
                            <option value="4">⭐4</option>
                            <option value="3">⭐3</option>
                            <option value="2">⭐2</option>
                            <option value="1">⭐1</option>
                        </select>
                        <button class="w-full border border-primary py-5 rounded-lg mt-2">평가 남기기</button>
                    </div>
                </form>
            @elseif(Auth::id() === $lecture->professor_id)
                <p class="text-center border border-gray-300 rounded-xl my-5 py-3">교수자는 자기 강의평을 작성할 수 없습니다.</p>
            @elseif(Auth::check() && $lecture->subscriptions->where('student_id', Auth::id())->count() == 0)
                <p class="text-center border border-gray-300 rounded-xl my-5 py-3">구독 후 작성 가능합니다.</p>
            @elseif(Auth::check())
                <p class="text-center border border-gray-300 rounded-xl my-5 py-3">기존 강의평을 삭제 후 작성 가능합니다.</p>
            @else
                <p class="text-center border border-gray-300 rounded-xl my-5 py-3">로그인 후 작성 가능합니다.</p>
            @endif

            <ul>
                @foreach($lecture->reviews as $review)
                    <li class="border-b border-gray-200 p-4">
                        <div class="flex justify-between">
                            <p class="text">
                                <b>{{$review->student->name}}</b> | <span>{{$review->created_at}}</span> | ⭐{{$review->rating}}
                            </p>
                            @if(Auth::check() && $review->student->id == Auth::id())
                                <form action="/review/{{$review->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button>❌</button>
                                </form>
                            @endif
                        </div>
                        <p class="text-lg">{{$review->comment}}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


</x-app>
