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
  <title>큐알주문 - 주문현황</title>
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
        <li class="py-4 text-zinc-800"><a href="qrcode.do">QR 코드</a></li>
        <li class="py-4 text-zinc-800 active"><a href="orderStatus.do">주문 현황</a></li>
      </ul>
    </aside>
    <div class="w-full h-full p-16">
      <div class="flex justify-between">
        <h1 class="text-3xl font-bold">주문 현황</h1>
        <c:if test="${param.completed != '1'}">
          <a href="orderStatus.do?completed=1" class="border border-black rounded-md p-3">완료한 주문 보기</a>
        </c:if>
        <c:if test="${param.completed == '1'}">
          <a href="orderStatus.do" class="border border-black rounded-md p-3">진행중인 주문 보기</a>
        </c:if>
      </div>

      <div class="h-12"></div>

      <div class="h-[77vh] overflow-y-scroll">
        <c:forEach var="order" items="${requestScope.orders}">
          <c:set var="totalPrice" value="0" />
          <div class="border-black border p-6 rounded-xl mb-8">
            <h1 class="text-2xl">${order.table}</h1>
            <c:forEach var="menus" items="${order.orderItems}">
              <c:set var="totalPrice" value="${totalPrice + menus.merch_price * menus.amount}" />
              <div class="flex justify-between">
                <p class="text-lg py-2">${menus.merch_name} ${menus.amount}개</p>
                <p>주문 시간: ${menus.created_at}</p>
              </div>
              <c:if test="${not empty menus.notes}">
                <div>
                  <small>ㄴ 주문사항: ${menus.notes}</small>
                </div>
              </c:if>
            </c:forEach>
            <div class="flex justify-between mt-6">
              <p>주문 시간: ${order.created_time}</p>
              <p>주문 금액: ${totalPrice}원</p>
            </div>
            <form action="orderStatus.do" method="POST" class="flex flex-row-reverse mt-4">
              <input type="hidden" name="id" value="${order.id}">
              <c:if test="${param.completed != '1'}">
                <button class="rounded-lg px-4 py-2 bg-blue-500 text-white">완료하기</button>
              </c:if>
            </form>
          </div>
        </c:forEach>
      </div>
    </div>
  </div>
</div>

<c:if test="${not empty sessionScope.msg}">
  <script>
    alert('${sessionScope.msg}')
  </script>
  <c:remove var="msg" scope="session" />
</c:if>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>