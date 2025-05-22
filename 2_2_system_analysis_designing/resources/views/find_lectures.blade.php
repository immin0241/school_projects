<x-app>
    <div class="w-full flex items-center justify-center">
        <div class="max-w-screen-xl w-full flex py-20 justify-center">
            <div class="w-9/12">
                <div class="flex justify-between pb-4">
                    <b class="text-lg">강의 {{$lectures->count()}}</b>
                    <select id="sort_options">
                        <option value="-1" selected disabled>--선택--</option>
                        <option value="0">최근 개설 순</option>
                        <option value="1">평점순</option>
                        <option value="2">강의평 순</option>
                    </select>
                </div>
                <div class="grid grid-cols-3 gap-4" id="lecture_list">
                    @foreach($lectures as $lecture)
                        <x-lecture-card
                            image="{{asset($lecture->thumbnail)}}"
                            title="{{$lecture->title}}"
                            id="{{$lecture->id}}"
                            review_count="{{$lecture->reviews()->count() ?? 0}}"
                            rating="{{round($lecture->reviews()->avg('rating') ?? 0, 1)}}"
                        />
                    @endforeach

                    @if($lectures->isEmpty())
                        <div class="w-full h-80 flex items-center justify-center col-span-3">
                            강의가 없습니다.
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </div>

    <script>
        const sort_type = document.getElementById("sort_options")
        sort_type.addEventListener("change", e => {
            const type = e.target.value;
            const parent = document.getElementById("lecture_list")
            const items = [...parent.children]

            const target = ["id", "rating", "review"][type];

            items.sort((a,b) => {
                return (a.dataset[target] * 1 < b.dataset[target] * 1) ? 1 : -1
            })

            while(parent.firstChild) {
                parent.removeChild(parent.lastChild)
            }

            parent.append(...items)
        }, false)
    </script>
</x-app>
