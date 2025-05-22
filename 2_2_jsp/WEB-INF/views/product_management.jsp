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
    <title>큐알주문 - 상품관리</title>
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
                    <li class="py-4 text-zinc-800"><a href="store.do">가게 정보</a></li>
                    <li class="py-4 text-zinc-800 active"><a href="merch.do">상품 관리</a></li>
                    <li class="py-4 text-zinc-800"><a href="qrcode.do">QR 코드</a></li>
                    <li class="py-4 text-zinc-800"><a href="orderStatus.do">주문 현황</a></li>
            </ul>
        </aside>
        <div class="w-full h-full p-16">
            <div class="flex justify-between">
                <h1 class="text-3xl font-bold">상품 관리</h1>
                <button data-modal-target="static-modal" data-modal-toggle="static-modal" class="border border-black rounded-md p-3">상품 추가하기</button>
            </div>
            <ul>
                <c:forEach var="merch" items="${requestScope.merch}">
                    <li class="flex justify-between items-center p-4 border-black border-b">
                        <div class="flex items-center">
                            <img src="image.do?filename=${merch.get('merch_picture')}" alt="상품 이미지" class="w-24 h-24 object-cover">
                            <div class="pl-6">
                                <span class="block">${merch.get('merch_name')}</span>
                                <small>${merch.get('merch_price')}원</small>
                            </div>
                        </div>
                        <form action="merch.do" method="POST">
                            <input type="hidden" name="isDelete" value="true">
                            <input type="hidden" name="id" value="${merch.get('id')}">
                            <button>❌</button>
                        </form>
                    </li>
                </c:forEach>
            </ul>
        </div>
    </div>
</div>

<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <form action="merch.do" method="POST" enctype="multipart/form-data" class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900">
                    상품 추가
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                    <span>❌</span>
                    <span class="sr-only">창 닫기</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <label class="w-full mb-4 block">
                    <span class="text-zinc-700 block">상품 이름</span>
                    <input type="text" class="w-full bg-zinc-300 rounded-xl h-12 px-4" placeholder="" name="merch_name">
                </label>
                <label class="w-full mb-4 block">
                    <span class="text-zinc-700 block">상품 가격</span>
                    <input type="text" class="w-full bg-zinc-300 rounded-xl h-12 px-4" placeholder="" name="merch_price">
                </label>
                <label class="w-full mb-4 block">
                    <span class="text-zinc-700 block">상품 이미지</span>
                    <input type="file" class="w-full bg-zinc-300 rounded-xl h-12 px-4" placeholder="" name="merch_picture">
                </label>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b flex-row-reverse">
                <button data-modal-hide="static-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-4">등록하기</button>
                <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">취소</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<style>
    input[type="file"]::file-selector-button {
        padding: 4px;
        margin-left: 8px;
        margin-top: 12px;
        background: gray
    }
</style>

<c:if test="${not empty sessionScope.msg}">
    <script>
        alert('${sessionScope.msg}')
    </script>
    <c:remove var="msg" scope="session" />
</c:if>
</body>

</html>