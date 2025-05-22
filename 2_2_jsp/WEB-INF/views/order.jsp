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
    <title>${requestScope.storeName} - 주문하기</title>
</head>

<body>
<div class="w-[100vw] h-[100vh] fixed left-0 top-0 overflow-hidden">
    <div class="w-full h-14 bg-slate-900 text-white font-bold justify-between items-center flex px-8">
        <div></div>
        <p>${requestScope.storeName}</p>
        <div>${requestScope.tableName}</div>
    </div>
    <div class="flex h-full">
        <aside class="w-80 h-full bg-slate-300 p-10 hidden xl:block">
            <ul>
                <li class="py-4 text-zinc-800 active"><a href="order.do?table_no=${param.table_no}&store_no=${param.store_no}">주문하기</a></li>
                <li class="py-4 text-zinc-800"><a href="receipt.do?table_no=${param.table_no}&store_no=${param.store_no}">주문 내역</a></li>
            </ul>
        </aside>
        <div class="w-full h-full p-16">
            <div class="flex justify-between">
                <h1 class="text-3xl font-bold">주문하기</h1>
                <a href="receipt.do?table_no=${param.table_no}&store_no=${param.store_no}" class="p-2 border-gray-600 border rounded-lg xl:hidden">주문내역 보기</a>
            </div>

            <div class="h-12"></div>

            <div class="h-[77vh] overflow-y-scroll">
                <ul>
                    <c:forEach var="merch" items="${requestScope.merchData}">
                        <li class="flex justify-between items-center p-4 border-black border-b flex-col xl:flex-row">
                            <div class="flex items-center">
                                <img src="image.do?filename=${merch.get('merch_picture')}" alt="상품 이미지" class="xl:w-24 xl:h-18 w-16 h-16">
                                <div class="pl-6">
                                    <span class="block">${merch.get('merch_name')}</span>
                                    <small>${merch.get('merch_price')}원</small>
                                </div>
                            </div>
                            <form action="order.do" method="post">
                                <input type="hidden" name="table_no" value="${param.table_no}">
                                <input type="hidden" name="store_no" value="${param.store_no}">
                                <input type="hidden" name="order_item" value="${merch.id}">
                                <input type="text" name="notes" class="xl:w-60 w-full border-b-2 border-l-0 border-t-0 border-r-0 border-black inline-block xl:mr-6" placeholder="요구사항">
                                <div class="xl:inline-block flex justify-between items-center mt-2 xl:mt-0">
                                    <input type="text" name="amount" class="w-8 border-b-2 border-l-0 border-t-0 border-r-0 border-black" value="1">개
                                    <button class="py-2 px-4 bg-blue-500 rounded-lg text-white ml-4">주문하기</button>
                                </div>
                            </form>
                        </li>
                    </c:forEach>
                </ul>
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