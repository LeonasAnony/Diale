function goBack() {
  window.location = "index.php";
}
function addMember() {
  document.getElementById('AddMemberModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
  document.documentElement.scrollTop = 0;
}
function showSidebar() {
  document.getElementById('SidebarModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
}
function closeSidebar() {
  document.getElementById('SidebarModal').style.display = "none";
  document.getElementById('ModalBackground').style.display = "none";
}
function edit() {
  document.getElementById('editTeamModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
  document.documentElement.scrollTop = 0;
}
window.onclick = function(event) {
  if (event.target == document.getElementById('ModalBackground')) {
    document.getElementById('editTeamModal').style.display = "none";
    document.getElementById('SidebarModal').style.display = "none";
    document.getElementById('AddMemberModal').style.display = "none";
    document.getElementById('ModalBackground').style.display = "none";
  }
}
function Messenger() {
   window.location = "";
}
function Pads() {
   window.location = "/pad/";
}
function Boards() {
   window.location = "";
}
function Kalender() {
   window.location = "";
}
function Datein() {
   window.location = "";
}
