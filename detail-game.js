const video = document.getElementById("mainVideo");
const image = document.getElementById("mainImage");
const thumbs = document.querySelectorAll(".gallery-thumb");
const videoThumb = document.querySelector(".video-thumb");

// Handle image thumbnails
thumbs.forEach((thumb) => {
    if (!thumb.classList.contains("video-thumb")) {
        thumb.addEventListener("click", () => {
            video.pause();
            video.classList.add("d-none");
            image.src = thumb.src;
            image.classList.remove("d-none");
            image.classList.add("show");
        });
    }
});

// Click main image to return to video
image.addEventListener("click", () => {
    image.classList.remove("show");
    setTimeout(() => {
        image.classList.add("d-none");
        video.classList.remove("d-none");
    }, 300);
});

// Click video thumbnail to return to video
videoThumb.addEventListener("click", () => {
    image.classList.remove("show");
    setTimeout(() => {
        image.classList.add("d-none");
        video.classList.remove("d-none");
        video.play();
    }, 300);
});

// Auto-play video when it becomes visible
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !video.classList.contains("d-none")) {
            video.play();
        }
    });
});

observer.observe(video);