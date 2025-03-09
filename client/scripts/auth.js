const API_BASE_URL = "http://localhost/faq-system/server/user/v1/auth";

// Registers a new user, stores the received token, and redirects to home.
async function registerUser() {
    const fullname = document.getElementById("register-fullname").value;
    const email = document.getElementById("register-email").value;
    const password = document.getElementById("register-password").value;
    const errorMessage = document.getElementById("register-errorMessage");

    errorMessage.innerText = "";

    if (!fullname || !email || !password) {
        errorMessage.innerText = "All fields are required!";
        return;
    }

    try {
        const response = await axios.post(`${API_BASE_URL}/register.php`, {
            fullname,
            email,
            password
        });

        if (response.data.error) {
            errorMessage.innerText = response.data.error;
        } else {
            localStorage.setItem("token", response.data.token);
            window.location.href = "home.html";
        }
    } catch (error) {
        errorMessage.innerText = "Registration failed. Please try again.";
    }
}

// Logs in an existing user, stores the token, and redirects to home.
async function loginUser() {
    const email = document.getElementById("login-email").value;
    const password = document.getElementById("login-password").value;
    const errorMessage = document.getElementById("login-errorMessage");

    errorMessage.innerText = ""; 

    if (!email || !password) {
        errorMessage.innerText = "Both email and password are required!";
        return;
    }

    try {
        const response = await axios.post(`${API_BASE_URL}/login.php`, {
            email,
            password
        });

        if (response.data.error) {
            errorMessage.innerText = response.data.error;
        } else {
            localStorage.setItem("token", response.data.token);
            window.location.href = "home.html";
        }
    } catch (error) {
        errorMessage.innerText = "Login failed. Please check your credentials.";
    }
}

// Checks if a user is authenticated; if not, redirects to the login page.
function checkAuth() {
    const token = localStorage.getItem("token");
    if (!token) {
        window.location.href = "index.html";
    }
}
