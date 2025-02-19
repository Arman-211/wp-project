document.addEventListener("DOMContentLoaded", function () {
    const categories = document.querySelectorAll(".filters button");
    categories.forEach(btn => {
        btn.addEventListener("click", function () {
            categories.forEach(b => b.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
