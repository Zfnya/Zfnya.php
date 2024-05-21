document.addEventListener("DOMContentLoaded", function () {
  const images = document.querySelectorAll(".gallery img");

  images.forEach(function (image) {
    image.addEventListener("mouseenter", function () {
      image.style.transform = "scale(1.05)";
    });

    image.addEventListener("mouseleave", function () {
      image.style.transform = "scale(1)";
    });
  });
});
