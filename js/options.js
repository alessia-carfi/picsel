export function openOptions(options, shadow) {
  if (options.style.display === "none") {
    options.style.display = "flex";
    options.style.backgroundColor = "var(--color-purple)";
    options.style.flexDirection = "column";
    options.style.alignItems = "center";
    options.style.position = "fixed";
    options.style.width = "100%";
    options.style.height = "35%";
    options.style.zIndex = "10";
    options.style.borderRadius = "0 0 2rem 2rem";

    shadow.style.display = "flex";
    shadow.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    shadow.style.position = "fixed";
    shadow.style.width = "100%";
    shadow.style.height = "100%";
    shadow.style.zIndex = "9";
  }
}
