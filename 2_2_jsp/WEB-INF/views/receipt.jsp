<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="${pageContext.request.contextPath}/resources/tailwind.css">
  <title>${requestScope.storeName} - 주문내역</title>
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
        <li class="py-4 text-zinc-800"><a href="order.do?table_no=${param.table_no}&store_no=${param.store_no}">주문하기</a></li>
        <li class="py-4 text-zinc-800 active"><a href="receipt.do?table_no=${param.table_no}&store_no=${param.store_no}">주문 내역</a></li>
      </ul>
    </aside>
    <div class="w-full h-full p-16">
      <div class="flex justify-between">
        <h1 class="text-3xl font-bold">주문 내역</h1>
        <a href="order.do?table_no=${param.table_no}&store_no=${param.store_no}" class="p-2 border-gray-600 border rounded-lg xl:hidden">주문하기</a>
      </div>

      <div class="h-12"></div>

      <div class="h-[77vh] overflow-y-scroll">
        <ul>
          <c:forEach var="order" items="${requestScope.orderData}">
            <li class="flex justify-between items-center p-4 border-black border-b flex-col xl:flex-row">
              <div class="flex items-center w-full xl:w-auto">
                <img src="image.do?filename=${order.get('merch_picture')}" alt="상품 이미지" class="w-16 h-16 xl:w-24 xl:h-16">
                <div class="pl-6">
                  <span class="block">${order.get('merch_name')}</span>
                  <small>${order.get('merch_price')}원</small><br>
                  <c:if test="${not empty order.get('notes')}">
                    <small>주문사항: ${order.get('notes')}</small>
                  </c:if>
                </div>
              </div>
              <div class="text-right flex flex-row xl:flex-col justify-between w-full xl:w-auto pt-3 xl:pt-0">
                <c:set var="createdAt" value="${order.get('created_at')}" />
                <c:set var="lengthMinusTwo" value="${16}" />
                <c:set var="result" value="${fn:substring(createdAt, 0, lengthMinusTwo)}" />
                <p>주문시각: ${result}</p>
                <p>${order.get('amount')}개</p>
              </div>
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