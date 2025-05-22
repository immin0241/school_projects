<x-app>

    <div class="flex items-center justify-center py-20">
        <form class="w-full max-w-screen-md" action="{{route('lecture.upload')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lecture_room_id" value="{{$idx}}">
            <h1 class="text-3xl font-bold">강좌 업로드</h1>

            <label class="py-4 block">
                <span class="block text">강좌 제목</span>
                <input type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </label>
            <label class="py-2 block">
                <span class="block text">영상 파일</span>
                <input type="file" id="thumbnail_upload" name="video" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </label>

            <div class="mt-10">
                <button class="w-full h-10 border border-primary rounded-lg hover:bg-primary hover:border-none transition-all hover:text-white">업로드하기</button>
            </div>
        </form>
    </div>

</x-app>
