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
