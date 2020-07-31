function reload() {
  window.location = "index.php";
}
function Team(teamid) {
  window.location = "team.php?id=" + teamid;
}
function Direct(directid) {
  window.location = "direct.php?id=" + directid;
}
function Logout() {
  window.location = "login.php?logout=true"
}
function NewTeam() {
  document.getElementById('NewTeamModal').style.display = "block";
  document.getElementById('NewTeamModalBackground').style.display = "block";
  document.documentElement.scrollTop = 0;
}
function NewDirect() {
  document.getElementById('NewDirectModal').style.display = "block";
  document.getElementById('NewTeamModalBackground').style.display = "block";
  document.documentElement.scrollTop = 0;
}
function Options() {
  document.getElementById('OptionsModal').style.display = "block";
  document.getElementById('NewTeamModalBackground').style.display = "block";
  document.documentElement.scrollTop = 0;
}
window.onclick = function(event) {
  if (event.target == document.getElementById('NewTeamModalBackground')) {
    document.getElementById('NewTeamModal').style.display = "none";
    document.getElementById('NewDirectModal').style.display = "none";
    document.getElementById('OptionsModal').style.display = "none";
    document.getElementById('NewTeamModalBackground').style.display = "none";
  }
}
