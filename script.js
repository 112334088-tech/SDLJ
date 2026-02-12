
/***********************
 * LOAD REMEMBERED USER
 ***********************/
window.onload = function () {
    const rememberedUser = localStorage.getItem("rememberedUser");

    if (rememberedUser && document.getElementById("username")) {
        document.getElementById("username").value = rememberedUser;
        document.getElementById("rememberMe").checked = true;
    }
};

/***********************
 * LOGIN FUNCTION
 ***********************/
function login() {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const rememberMe = document.getElementById("rememberMe").checked;
    const errorMsg = document.getElementById("errorMsg");

    if (username === "" || password === "") {
        errorMsg.textContent = "Please fill all fields!";
        return;
    }

    // Get registered user
    const savedUser = JSON.parse(localStorage.getItem("user"));

    if (!savedUser) {
        errorMsg.textContent = "No user found. Please register first.";
        return;
    }

    if (username === savedUser.username && password === savedUser.password) {

        // Remember Me logic
        if (rememberMe) {
            localStorage.setItem("rememberedUser", username);
        } else {
            localStorage.removeItem("rememberedUser");
        }

        errorMsg.textContent = "";
        alert("Thank You For Coming To Login Successfully!");
        // redirect if needed
        // window.location.href = "dashboard.html";

    } else {
        errorMsg.textContent = "Invalid username or password!";
    }
}

/***********************
 * REGISTER FUNCTION
 ***********************/
function register() {
    const username = document.getElementById("regUsername").value.trim();
    const email = document.getElementById("regEmail").value.trim();
    const mobile  = document.getElementById("regmobile").value.trim();
    const password = document.getElementById("regPassword").value.trim();
    const confirmPassword = document.getElementById("regConfirmPassword").value.trim();
    const error = document.getElementById("regError");

    if (mobile === ""|| username === "" || email === "" || password === "" || confirmPassword === "") {
        error.textContent = "All fields are required!";
        return;
    }

    if (password.length < 5) {
        error.textContent = "Password must be at least 5 characters!";
        return;
    }

    if (password !== confirmPassword) {
        error.textContent = "Passwords do not match!";
        return;
    }

    // Save user to localStorage (demo purpose)
    const user = {
        username: username,
        email: email,
        password: password,
        mobile: mobile
    };

    localStorage.setItem("user", JSON.stringify(user));

    alert("congratulations You Are Successfully Registered ! Go To Login Buddies.");
    window.location.href = "index.html";
}

/***********************
 * FORGOT PASSWORD
 ***********************/
function forgotPassword() {
    const savedUser = JSON.parse(localStorage.getItem("user"));

    if (!savedUser) {
        alert("No user found. Please register first.");
        return;
    }

    alert(
        "Demo message:\n\n" +
        "Password reset link sent to:\n" +
        savedUser.email
    );
}
