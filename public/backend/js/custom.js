// dropdown menu
document.addEventListener("DOMContentLoaded", function () {
    document
    .querySelectorAll('.sidebar-link[data-bs-toggle="collapse"]')
    .forEach((link) => {
        let icon = link.querySelector(".toggle-icon");
        let targetMenu = document.querySelector(link.getAttribute("href"));

        targetMenu.addEventListener("show.bs.collapse", function () {
            document
                .querySelectorAll(".collapse.show")
                .forEach((openMenu) => {
                    if (openMenu !== targetMenu) {
                        let openIcon = document.querySelector(
                            `.sidebar-link[href="#${openMenu.id}"] .toggle-icon`
                        );
                        new bootstrap.Collapse(openMenu, {
                            toggle: false,
                        }).hide();
                        if (openIcon) {
                            openIcon.classList.replace(
                                "fa-chevron-down",
                                "fa-chevron-right"
                            );
                        }
                    }
                });

            if (icon) {
                icon.classList.replace(
                    "fa-chevron-right",
                    "fa-chevron-down"
                );
            }
        });

        targetMenu.addEventListener("hide.bs.collapse", function () {
            if (icon) {
                icon.classList.replace(
                    "fa-chevron-down",
                    "fa-chevron-right"
                );
            }
        });

        if (targetMenu.classList.contains("show")) {
            if (icon) {
                icon.classList.replace(
                    "fa-chevron-right",
                    "fa-chevron-down"
                );
            }
        }
    });
});

// Get Elements
const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const cancelBtn = document.getElementById("cancelBtn");
const customModal = document.getElementById("customModal");

// Open Modal
openModalBtn.addEventListener("click", () => {
    customModal.style.display = "block";
});

// Close Modal
closeModalBtn.addEventListener("click", () => {
    customModal.style.display = "none";
});

cancelBtn.addEventListener("click", () => {
    customModal.style.display = "none";
});

// Close Modal when clicking outside of the modal
window.addEventListener("click", (e) => {
    if (e.target === customModal) {
        customModal.style.display = "none";
    }
});
