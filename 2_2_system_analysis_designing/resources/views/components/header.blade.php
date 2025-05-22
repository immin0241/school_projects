<header class="w-full shadow-md">
    <div class="max-w-screen-2xl flex justify-between mx-auto px-8 items-center py-4">
        <div class="flex w-4/5 items-center">
            <a href="/">
                <img src="/logo.png" alt="logo image" class="object-contain w-40">
            </a>
            <div class="w-14"></div>
            <nav>
                <ul class="flex">
                    <li><a href="{{route("lecture_find")}}">강의</a></li>
                    @if(Auth::check() && Auth::user()->type === "02")
                        <li class="w-8"></li>
                        <li><a href="{{Route("professor.index")}}">마이페이지</a></li>
                    @elseif(Auth::check() && Auth::user()->type === "02")
                        <li class="w-8"></li>
                        <li><a href="{{Route("my_page", Auth::id())}}">마이페이지</a></li>
                    @endif
                </ul>
            </nav>
            <div class="w-12"></div>
            <form action="/lecture" method="get" class="search rounded-lg max-w-screen-md w-full bg-gray-200 border border-gray-400 h-10 relative px-1 py-1">
                <input type="text" name="query" class="w-[96%] bg-transparent h-full focus:outline-none active:outline-none active:borer-b-white border-none">
                <button>🔍</button>
            </form>
        </div>
        <ul class="flex items-center">
            @guest
            <li class="flex items-center justify-center rounded-md border border-gray-200 px-4 py-2.5">
                <a href="/login" class="w-full h-full">로그인</a>
            </li>
            <li class="w-4"></li>
            <li class="flex items-center justify-center rounded-md border border-gray-200 px-4 py-2.5 bg-primary text-white">
                <a href="/register" class="w-full h-full">회원가입</a>
            </li>
            @endguest
            @auth
                <form action="{{route('logout')}}" method="POST" class="flex items-center">
                    @csrf
                    <p class="pr-5">환영합니다, {{Auth::user()->name}}님.</p>
                    <button class="cursor-pointer flex items-center justify-center rounded-md border border-gray-200 px-4 py-2.5 bg-primary text-white">로그아웃</button>
                </form>
            @endauth
        </ul>
    </div>
</header>
