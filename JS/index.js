function reload() {
  window.location = "index.php";
}
function Team(teamid) {
  window.location = "team.php?id=" + teamid;
}
function Direct(directid) {
  window.location = "direct.php?id=" + directid;
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
window.onclick = function(event) {
  if (event.target == document.getElementById('NewTeamModalBackground')) {
    document.getElementById('NewTeamModal').style.display = "none";
    document.getElementById('NewDirectModal').style.display = "none";
    document.getElementById('NewTeamModalBackground').style.display = "none";
  }
}
