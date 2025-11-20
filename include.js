// =============================================
//  OPTIMIZED INCLUDE SYSTEM
// =============================================
async function loadIncludes(callback) {
    const includes = document.querySelectorAll("[data-include]");

    if (includes.length === 0) {
        callback();
        return;
    }

    // Load semua includes secara paralel
    const promises = Array.from(includes).map(async (el) => {
        const file = el.getAttribute("data-include") + ".html";

        try {
            const response = await fetch(file);
            if (!response.ok) throw new Error(`Failed to load ${file}`);
            const html = await response.text();
            el.innerHTML = html;
        } catch (error) {
            console.error(`Error loading ${file}:`, error);
            el.innerHTML = `<p>Error loading content</p>`;
        }
    });

    // Tunggu semua selesai
    await Promise.all(promises);
    callback();
}

// =============================================
//  OPTIMIZED EDGE PANEL INITIALIZER
// =============================================
function initEdgePanel() {
    const toggle = document.getElementById("edgeToggle");
    const sidebar = document.getElementById("edgeSidebar");

    if (!toggle || !sidebar) {
        console.warn("Edge panel elements not found");
        return;
    }

    // Event delegation untuk outside click
    let outsideClickHandler = null;

    toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        const isActive = sidebar.classList.toggle("active");

        if (isActive) {
            // Tambah event listener untuk close ketika aktif
            outsideClickHandler = (event) => {
                if (!sidebar.contains(event.target) && event.target !== toggle) {
                    sidebar.classList.remove("active");
                    document.removeEventListener("click", outsideClickHandler);
                    outsideClickHandler = null;
                }
            };

            // Delay sedikit biar tidak langsung trigger
            setTimeout(() => {
                document.addEventListener("click", outsideClickHandler);
            }, 10);
        } else if (outsideClickHandler) {
            // Hapus listener ketika non-aktif
            document.removeEventListener("click", outsideClickHandler);
            outsideClickHandler = null;
        }
    });
}

// =============================================
//  OPTIMIZED STARTUP
// =============================================
document.addEventListener("DOMContentLoaded", () => {
    // Jalankan tanpa delay
    loadIncludes(() => {
        initEdgePanel();
    });
});