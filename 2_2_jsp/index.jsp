<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<html>
<head>
    <title>Title</title>
</head>
<body>
<script>
    location.href = "http://${pageContext.request.localAddr}:8181<%=request.getContextPath()%>/main.do"
</script>
</body>
</html>
