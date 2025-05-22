<x-app>

    <div class="flex items-center justify-center py-20">
        <form class="w-full max-w-screen-md" action="{{route('professor.create_lecture')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h1 class="text-3xl font-bold">강의 생성하기</h1>

            <label class="py-4 block">
                <span class="block text">강의 제목</span>
                <input type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </label>
            <label class="py-2 block">
                <span class="block text">강의 설명</span>
                <textarea type="text" name="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-40 resize-none" required></textarea>
            </label>
            <label class="py-2 block">
                <span class="block text">강의 썸네일</span>
                <input type="file" id="thumbnail_upload" name="thumbnail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 h-60 flex items-center justify-center" id="preview">

            </div>
            <span class="text-sm mt-2 inline-block text-gray-500">* 680x440 크기의 이미지를 올려주세요.</span>

            <div class="mt-10">
                <button class="w-full h-10 border border-primary rounded-lg hover:bg-primary hover:border-none transition-all hover:text-white">생성하기</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("thumbnail_upload").addEventListener("change", evt => {
            const {files} = evt.target
            if(!files.length) return;

            const file = files[0];
            const reader = new FileReader();
            reader.readAsDataURL(file)
            reader.onload = (e) => {
                const preview = document.getElementById("preview")
                const img = new Image();

                img.src = e.target.result;
                img.style.width = '340px'
                img.style.height = '220px'
                img.style.objectFit = 'contain'

                img.onload = (e) => {
                    preview.replaceChildren(e.target)
                }
            }
        }, false)
    </script>

</x-app>
