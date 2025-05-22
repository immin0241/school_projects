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
    <title>로그인</title>
</head>

<body>
    <div class="w-[100vw] h-[100vh] bg-slate-300 fixed left-0 top-0 center-element">
        <div class="bg-slate-200 rounded-xl shadow-md w-1/3">
            <form action="main.do" method="POST" class="text-center flex flex-col py-8">
                <h1 class="text-2xl font-bold">로그인</h1>
                <input type="text" name="id" class="m-3" placeholder="아이디">
                <input type="password" name="password" class="m-3" placeholder="비밀번호">
                <div class="flex w-full">
                    <button class="rounded-md p-2 m-4 bg-blue-500 text-white flex-1">로그인</button>
                    <div class="w-1"></div>
                    <a href="join.do" class="rounded-md p-2 m-4 border border-blue-500 flex-1">회원가입</a>
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