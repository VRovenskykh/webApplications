$(document).ready(function () {
    // Переключение вкладок
    $("#login-tab").click(() => {
        $("#login-form").show();
        $("#register-form").hide();
    });

    $("#register-tab").click(() => {
        $("#register-form").show();
        $("#login-form").hide();
    });

    // AJAX для входа
    $("#login-form").submit(function (e) {
        e.preventDefault();
        const email = $("#login-email").val();
        const password = $("#login-password").val();

        $.post("server.php", { action: "login", email, password }, function (response) {
            if (response.success) {
                window.location.href = "profile.html";
            } else {
                $("#message").text(response.message);
            }
        }, "json");
    });

    // AJAX для регистрации
    $("#register-form").submit(function (e) {
        e.preventDefault();
        const username = $("#register-username").val();
        const email = $("#register-email").val();
        const password = $("#register-password").val();
        const confirmPassword = $("#register-confirm-password").val();

        if (password !== confirmPassword) {
            $("#message").text("Пароли не совпадают!");
            return;
        }

        $.post("server.php", { action: "register", username, email, password }, function (response) {
            if (response.success) {
                alert("Успішна реєстрація!");
                window.location.href = "index.html";
            } else {
                $("#message").text(response.message);
            }
        }, "json");
    });

    // AJAX для обновления профиля
    $("#profile-form").submit(function (e) {
        e.preventDefault();
        const username = $("#update-username").val();
        const password = $("#update-password").val();

        $.post("server.php", { action: "updateProfile", username, password }, function (response) {
            if (response.success) {
                alert("Профіль оновлено!");
            } else {
                alert(response.message);
            }
        }, "json");
    });

    // Выход
    $("#logout").click(function () {
        $.post("server.php", { action: "logout" }, function () {
            window.location.href = "index.html";
        });
    });
});
