const covered = ["loudon","lenoir city","knoxville","farragut","maryville","kingston","oak ridge","philadelphia","37774","37771","379","37801","37803","37763","37772","37830"];
function checkArea(){
  const value = document.getElementById("areaInput").value.toLowerCase().trim();
  const result = document.getElementById("areaResult");
  if(!value){ result.textContent = "Enter your city or ZIP code and we’ll check it."; return; }
  const yes = covered.some(area => value.includes(area) || area.includes(value));
  result.textContent = yes
    ? "Yes — Loudon Mechanical Services serves this area. Call 865-964-6348."
    : "We may still serve your area. Call 865-964-6348 and we’ll confirm availability.";
}
document.getElementById("year").textContent = new Date().getFullYear();
