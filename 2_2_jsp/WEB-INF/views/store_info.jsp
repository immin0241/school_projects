<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="${pageContext.request.contextPath}/resources/tailwind.css">
    <title>큐알주문 - 가게정보</title>
</head>

<body>
    <div class="w-[100vw] h-[100vh] fixed left-0 top-0 overflow-hidden">
            <div class="w-full h-14 flex items-center justify-between bg-slate-900 text-white font-bold px-8">
        <div></div>
        <div>큐알주문</div>
        <div><a href="logout.do">로그아웃</a></div>
    </div>
        <div class="flex h-full">
            <aside class="w-80 h-full bg-slate-300 p-10">
                <ul>
                    <li class="py-4 text-zinc-800 active"><a href="store.do">가게 정보</a></li>
                    <li class="py-4 text-zinc-800"><a href="merch.do">상품 관리</a></li>
                    <li class="py-4 text-zinc-800"><a href="qrcode.do">QR 코드</a></li>
                    <li class="py-4 text-zinc-800"><a href="orderStatus.do">주문 현황</a></li>
                </ul>
            </aside>
            <form action="store.do" method="POST" class="w-full h-full p-16">
                <h1 class="text-3xl font-bold">가게 정보</h1>
                <label class="w-full pt-4 block">
                    <span class="text-zinc-700 block">가게 이름</span>
                    <input type="text" value="${requestScope.store_name}" class="w-full bg-zinc-300 rounded-xl h-12 px-4" name="store_name" placeholder="가게 이름">
                </label>
                <label class="w-full pt-4 block">
                    <span class="text-zinc-700 block">가게 설명</span>
                    <textarea class="w-full bg-zinc-300 rounded-xl h-12 p-4 resize-none h-80" name="store_desc" placeholder="가게 설명">${requestScope.store_desc}</textarea>
                </label>
                <div class="flex flex-row-reverse">
                    <button class="p-4 bg-blue-500 text-white rounded-md">수정하기</button>
                </div>
            </form>
        </div>
    </div>



    <c:if test="${not empty sessionScope.msg}">
        <script>
            alert('${sessionScope.msg}')
        </script>
        <c:remove var="msg" scope="session" />
    </c:if>
</body>

</html>