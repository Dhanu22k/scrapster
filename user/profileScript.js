let editBtn = document.getElementById("editBtn");
const submitBtn = document.getElementById("submitBtn");

var dialogBox = document.getElementById("dialogBox");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var file=document.getElementById('file');
var imgUpBtn=document.getElementById('imgUpBtn');

editBtn.addEventListener("click", () => {
  submitBtn.hidden = false;
  editBtn.hidden = true;
  let dataField = document.querySelectorAll("#dataField");
  for (let i = 0; i < dataField.length; i++) {
    dataField[i].readOnly = false;
    dataField[i].select();
    dataField[i].style.border = "2px solid red";
  }
  dataField[0].focus();
});



// When the user clicks the button, open the modal 
btn.addEventListener('click',()=>{
  dialogBox.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  dialogBox.style.display = "none";
}

file.addEventListener('input',()=>{
  imgUpBtn.hidden=false;
})