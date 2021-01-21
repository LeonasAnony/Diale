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
function Ready() {
  document.body.style.fontFamily = "Courier";
  document.body.style.lineHeight = "1.2";
  setTimeout(function() {
    $('.spinner').hide();
    $('.container').show();
  }, 1000);
}

$(window).load(setTimeout(Ready, 1000));

function coords(c) {
  $('#cropimagefield').val(c.x + ':' + c.y + ':' + c.w + ':' + c.h);
}
function Crop() {
  $('#cropimage').show();
//  $('.spinner').hide();
	$('#cropimage').Jcrop({
    onSelect:     coords,
    aspectRatio:  1 / 1,
    setSelect:    [ 200, 200, 0, 0 ],
    bgOpacity:    .4
  });
}
$('#uploadInput').on("change", function() {
  $('#cropimage').hide();
//  $('.spinner').show();
  const file = event.target.files[0];
  var img = document.getElementById('cropimage')

  if (!file.type) {
    $(status).textContent = 'Error: The File.type property does not appear to be supported on this browser.';
    return;
  }
  if (!file.type.match('image.*')) {
    $(status).textContent = 'Error: The selected file does not appear to be an image.'
    return;
  }
  var reader = new FileReader();
  reader.addEventListener('load', event => {
    img.src = event.target.result;
  });
  reader.readAsDataURL(file);

  reader.onload = function() {
    setTimeout(Crop, 20)
  }
});
