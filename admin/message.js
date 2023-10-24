var dialogBox = document.getElementById("dialogBox");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

  function hanndleMessage(event){
    dialogBox.style.display = "block";
    var messageid =event.target.value;
    var message =document.getElementById("msg"+messageid).innerHTML;
    document.getElementById("textArea").innerHTML=message;
    document.getElementById("msgid").value=messageid;
  }
  
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    dialogBox.style.display = "none";
  }



if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}