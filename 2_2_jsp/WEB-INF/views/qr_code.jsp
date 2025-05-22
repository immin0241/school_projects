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
    <title>큐알주문 - QR코드 관리</title>
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
                <li class="py-4 text-zinc-800"><a href="merch.do">상품 관리</a></li>
                <li class="py-4 text-zinc-800 active"><a href="qrcode.do">QR 코드</a></li>
                <li class="py-4 text-zinc-800"><a href="orderStatus.do">주문 현황</a></li>
            </ul>
        </aside>
        <div class="w-full h-full p-16">
            <form method="POST" action="qrcode.do" class="flex justify-between">
                <h1 class="text-3xl font-bold">QR 코드</h1>
                <div>
                    <input type="hidden" name="store_id" value="${sessionScope.id}">
                    <input type="text" class="w-80 border-0 border-b border-black h-12 px-4" placeholder="테이블 이름" name="table_name">
                    <button class="border border-black rounded-md p-3 inline-block ml-4">테이블 추가하기</button>
                </div>
            </form>
            <div class="justify-between grid grid-cols-4 mt-8">
                <c:forEach var="qr" items="${requestScope.data}">
                    <div class="flex flex-col items-center">
                        <p>${qr.table}</p>
                        <a href="http://${pageContext.request.localAddr}:${pageContext.request.localPort}${pageContext.request.contextPath}/order.do?store_no=${qr.store_id}&table_no=${qr.id}">
                            <img src="qrimage.do?store_no=${qr.store_id}&table_no=${qr.id}" alt="QR 코드" class="w-64 h-64">
                        </a>
                        <div class="flex">
                            <a href="qrimage.do?store_no=${qr.store_id}&table_no=${qr.id}" download="qr_${qr.table}.png" class="p-4 bg-blue-500 text-white rounded-md">QR 코드 다운로드</a>
                            <div class="w-4"></div>
                            <form action="qrcode.do" method="POST">
                                <input type="hidden" name="is_delete" value="true">
                                <input type="hidden" name="id" value="${qr.id}">
                                <button class="p-4 bg-red-500 text-white rounded-md">테이블 삭제하기</button>
                            </form>
                        </div>
                    </div>
                </c:forEach>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<c:if test="${not empty sessionScope.msg}">
    <script>
        alert('${sessionScope.msg}')
    </script>
    <c:remove var="msg" scope="session" />
</c:if>
</body>

</html>