<x-app>
    <div class="py-6 flex items-center justify-center">
        <div class="max-w-screen-xl w-full flex justify-between">
            <div class="py-6 w-[640px]">
                @php
                    $top = $hot_lectures->first();
                @endphp
                <div>
                    <p class="p-1 text-white rounded-lg bg-primary inline-block pr-3">🌟 인기 강좌</p>
                    @if($top)
                        <h1 id="title"
                            class="text-5xl font-bold break-keep pt-5 line-clamp-2">{{$top->title}}</h1>
                        <p id="description"
                           class="pt-8 w-[500px] text-gray-500 line-clamp-3">{{$top->description}}</p>
                        <a href="/lecture/{{$top->id}}"
                           class="rounded-lg text-white mt-10 rounded-lg bg-primary px-5 py-3 inline-flex" id="lecture_link">
                            <span>더 보기</span>
                            <img src="/arrow.png" alt="arrow" class="ml-4 object-contain">
                        </a>
                    @else
                        <h1 id="title" class="text-5xl font-bold break-keep pt-5">아직 개설된 강의가 없어요</h1>
                    @endif
                </div>
            </div>

            <div class="swiper w-[600px] h-[380px] border-orange-500 border-2 rounded-3xl overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($hot_lectures as $lecture)
                        <div class="swiper-slide h-[380px]">
                            <img src="{{asset($lecture->thumbnail)}}" alt="메인 이미지" class="object-fill size-full">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="h-10"></div>
    <div class="w-full flex items-center justify-center flex-col">
        <div class="max-w-screen-2xl w-full px-8">
            <div class="flex w-full py-6">
                <div class="w-1/4">
                    <h2 class="font-bold text-2xl">수강중인 강의</h2>
                    <p class="text-[18px] text-gray-500">현재 수강중인 강의들을 확인할 수 있습니다.</p>
                </div>

                <div class="grid grid-cols-3 gap-3 w-3/4 pl-12">
                    @auth
                        @foreach($user_lectures as $lecture)
                            <x-lecture-card
                                image="{{asset($lecture->thumbnail)}}"
                                title="{{$lecture->title}}"
                                id="{{$lecture->id}}"
                                review_count="{{$lecture->reviews()->count() ?? 0}}"
                                rating="{{round($lecture->reviews()->avg('rating') ?? 0, 1)}}"
                            />
                        @endforeach
                        @if($user_lectures?->isEmpty())
                            <div class="col-span-3 flex items-center justify-center h-96 border border-gray-400">
                                구독한 강의가 없습니다.
                            </div>
                        @endif
                    @endauth

                    @guest
                        <div class="col-span-3 flex items-center justify-center h-60 border border-gray-200">
                            로그인 후 확인 가능합니다.
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app>

<script>
    @php
        $hot_items = $hot_lectures->map(fn ($lecture) => [
            'title' => $lecture->title,
            'description' => $lecture->description,
            'url' => '/lecture/'.$lecture->id,
        ])->values();
    @endphp
    // 사용자 입력(제목·설명)을 스크립트 안에 그대로 넣지 않고 JSON으로 인코딩해 전달한다.
    const hot_items = {{ Js::from($hot_items) }}

    const swiper = new Swiper('.swiper', {
        direction: 'horizontal',
        loop: true,
        autoplay: {
            delay: 3000
        },
        on: {
            slideChange(e) {
                const idx = e.realIndex;
                const data = hot_items[idx]

                document.getElementById("title").innerText = data.title
                document.getElementById("description").innerText = data.description
                document.getElementById("lecture_link").href = data.url
            }
        }
    });
</script>
