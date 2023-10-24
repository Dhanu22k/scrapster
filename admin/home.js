var dialogBox = document.getElementById("dialogBox");
var span = document.getElementsByClassName("close")[0];

var rejectBtn = document.querySelectorAll("#rejectBtn");
for (var i = 0; i < rejectBtn.length; i++) {
  rejectBtn[i].addEventListener("click", (e) => {
    e.preventDefault();
    dialogBox.style.display = "block";
    var orderId = e.target.value;
    document.getElementById("oid").value=orderId;
  });
}
span.onclick = function () {
  dialogBox.style.display = "none";
};
