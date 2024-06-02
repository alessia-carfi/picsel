export function openSearch(search, profile, searchMobile) {
  searchMobile.style.display = "none";
  search.style.display = "flex";
  profile.style.display = "none";
  search.style.justifyContent = "start";
  search.style.backgroundColor = "var(--color-purple)";
  search.style.border = "1px solid var(--color-white)";
  search.style.borderRadius = "0.5rem";
  search.style.padding = "0.5rem 0.5rem";
  search.style.alignItems = "center";
  search.style.marginLeft = "2rem";
}
