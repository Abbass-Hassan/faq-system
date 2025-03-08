const API_BASE_URL = "http://localhost/faq-system/server/user/v1";

// Load FAQs from API
async function loadFAQs() {
    try {
        const response = await axios.get(`${API_BASE_URL}/get_faqs.php`);
        console.log("API Response:", response.data);
        const faqs = response.data.faqs;

        const faqList = document.getElementById("faq-list");
        faqList.innerHTML = "";

        if (!faqs || faqs.length === 0) {
            faqList.innerHTML = "<p>No FAQs available.</p>";
            return;
        }

        faqs.forEach(faq => {
            console.log("FAQ Object:", faq);

            const faqItem = document.createElement("div");
            faqItem.classList.add("faq-item");
            faqItem.innerHTML = `
                <div class="faq-question">
                    <strong>${faq.question}</strong>
                    <span>▼</span>
                </div>
                <p class="faq-answer">${faq.answer}</p>
            `;

            faqItem.addEventListener("click", () => {
                faqItem.classList.toggle("active");
            });

            faqList.appendChild(faqItem);
        });

    } catch (error) {
        console.error("Error fetching FAQs:", error);
        document.getElementById("faq-list").innerHTML = "<p>Failed to load FAQs.</p>";
    }
}

// Open Add FAQ Modal
function openFaqModal() {
    document.getElementById("faq-modal").style.display = "flex";
}

// Close Add FAQ Modal
function closeFaqModal() {
    document.getElementById("faq-modal").style.display = "none";
    document.getElementById("faq-question").value = "";
    document.getElementById("faq-answer").value = "";
    document.getElementById("faq-errorMessage").innerText = "";
}


// Add New FAQ
async function addFAQ() {
    const question = document.getElementById("faq-question").value.trim();
    const answer = document.getElementById("faq-answer").value.trim();
    const errorMessage = document.getElementById("faq-errorMessage");

    errorMessage.innerText = "";

    if (!question || !answer) {
        errorMessage.innerText = "Both fields are required!";
        return;
    }

    try {
        const token = localStorage.getItem("token"); // Get JWT token
        if (!token) {
            errorMessage.innerText = "Unauthorized. Please log in.";
            return;
        }

        const response = await axios.post(`${API_BASE_URL}/create_faq.php`, 
            { question, answer }, 
            { headers: { Authorization: `Bearer ${token}` } }
        );

        if (response.data.error) {
            errorMessage.innerText = response.data.error;
        } else {
            closeFaqModal();
            loadFAQs(); // Reload FAQs dynamically
        }
    } catch (error) {
        errorMessage.innerText = "Failed to add FAQ. Please try again.";
    }
}


// Filter FAQs based on search query
function filterFAQs() {
    const searchQuery = document.getElementById("faq-search").value.toLowerCase();
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach(item => {
        const question = item.querySelector(".faq-question").textContent.toLowerCase();
        item.style.display = question.includes(searchQuery) ? "block" : "none";
    });
}

