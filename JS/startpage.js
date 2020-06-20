function Team(teamid) {
  window.location = "team.php?id=" + teamid;
}
function NewTeam() {
  document.getElementById('NewTeamModal').style.display = "block";
  document.getElementById('NewTeamModalBackground').style.display = "block";
}
window.onclick = function(event) {
  if (event.target == document.getElementById('NewTeamModalBackground')) {
    document.getElementById('NewTeamModal').style.display = "none";
    document.getElementById('NewTeamModalBackground').style.display = "none";
  }
}
