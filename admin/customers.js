var stat = document.querySelectorAll("#status");
for (var i = 0; i < stat.length; i++) {
  if (stat[i].innerText == "Active") {
    stat[i].style.color = "green";
  } else {
    stat[i].style.color = "red";
  }
}
