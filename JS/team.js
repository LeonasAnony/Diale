function GoBack() {
  window.location = "index.php";
}
function AddMember() {
  document.getElementById('AddMemberModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
}
window.onclick = function(event) {
  if (event.target == document.getElementById('ModalBackground')) {
    document.getElementById('AddMemberModal').style.display = "none";
    document.getElementById('ModalBackground').style.display = "none";
  }
}
function ShowSidebar() {
  document.getElementById('SidebarModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
}
window.onclick = function(event) {
  if (event.target == document.getElementById('ModalBackground')) {
    document.getElementById('SidebarModal').style.display = "none";
    document.getElementById('ModalBackground').style.display = "none";
  }
}
function edit() {
  document.getElementById('editTeamModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
}
window.onclick = function(event) {
  if (event.target == document.getElementById('ModalBackground')) {
    document.getElementById('editTeamModal').style.display = "none";
    document.getElementById('ModalBackground').style.display = "none";
  }
}
