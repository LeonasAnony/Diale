function goBack() {
  window.location = "index.php";
}
function showSidebar() {
  document.getElementById('SidebarModal').style.display = "block";
  document.getElementById('ModalBackground').style.display = "block";
}
function closeSidebar() {
  document.getElementById('SidebarModal').style.display = "none";
  document.getElementById('ModalBackground').style.display = "none";
}
window.onclick = function(event) {
  if (event.target == document.getElementById('ModalBackground')) {
    document.getElementById('SidebarModal').style.display = "none";
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
